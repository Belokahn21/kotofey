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
        if (self::isBonused($order)) return false;

        $orderSumm = OrderHelper::orderSummary($order);
        $bonus = round($orderSumm * (UserBonus::PERCENT_AFTER_SALE / 100));

        return self::addHistory($order, $bonus, "Зачисление за заказ #" . $order->id);
    }

    public static function isBonused(Order $order)
    {
        return UserBonusHistory::findOne(['order_id' => $order->id]) instanceof UserBonusHistory;
    }

    public static function addHistory(Order $order, $count, $reason)
    {
        $obj = new UserBonusHistory();
        $obj->reason = $reason;
        $obj->count = $count;
        $obj->order_id = $order->id;
        $obj->bonus_account_id = $order->phone;
        $obj->is_active = true;

        return $obj->validate() && $obj->save();
    }

    public static function createBonusAccount($phone)
    {
        $obj = new UserBonusHistory();
        $obj->count = 0;
        $obj->is_active = 1;
        $obj->bonus_account_id = $phone;
        $obj->reason = "Аккаунт создан";
        return $obj->validate() && $obj->save();
    }
}