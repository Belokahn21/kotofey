<?php

namespace app\modules\bonus\models\helper;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;

class BonusHelper
{
    public static function applyUserBonus(Order $order)
    {
        $orderSumm = OrderHelper::orderSummary($order);
        $bonus = round($orderSumm * (UserBonus::PERCENT_AFTER_SALE / 100));

        $object = self::addBonusUser($order->phone, $bonus);

        if ($object instanceof UserBonus) {
            self::addHistory($object, $order, $bonus, "Зачисление за заказ #" . $order->id);
        }
    }

    public static function addBonusUser($phone, $bonus)
    {
        if (!$UserBonusEntity = UserBonus::findByPhone($phone)) return false;

        $UserBonusEntity->count += $bonus;

        if (!$UserBonusEntity->validate() || $UserBonusEntity->update() === false) return false;


        return $UserBonusEntity;

    }

    public static function addHistory(UserBonus $model, Order $order, $count, $reason)
    {
        $obj = new UserBonusHistory();
        $obj->reason = $reason;
        $obj->count = $count;
        $obj->order_id = $order->id;
        $obj->bonus_account_id = $model->id;

        return $obj->validate() && $obj->save();
    }

    public static function createBonusAccount($phone)
    {
        $obj = new UserBonus();
        $obj->phone = $phone;
        $obj->count = 0;

        return $obj->validate() && $obj->save();
    }
}