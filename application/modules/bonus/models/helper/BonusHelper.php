<?php

namespace app\modules\bonus\models\helper;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\tools\Debug;

class BonusHelper
{
    public static function applyUserBonus(Order $order, $active = true)
    {
        if (self::isBonused($order)) return false;
        return self::addHistory($order, self::calcResultBonus($order), "Зачисление за заказ #" . $order->id, $active);
    }

    public static function calcResultBonus(Order $order)
    {
        return round(OrderHelper::orderSummary($order) * (UserBonus::PERCENT_AFTER_SALE / 100));
    }

    public static function isBonused(Order $order)
    {
        return UserBonusHistory::findOne(['order_id' => $order->id]) instanceof UserBonusHistory;
    }

    public static function getUserBonus($phone)
    {
        return UserBonusHistory::find()->where(['bonus_account_id' => $phone, 'is_active' => true])->sum('count');
    }

    public static function addHistory(Order $order, $count, $reason, $active = true)
    {
        $obj = new UserBonusHistory();
        $obj->reason = $reason;
        $obj->count = $count;
        $obj->order_id = $order->id;
        $obj->bonus_account_id = $order->phone;
        $obj->is_active = $active;

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