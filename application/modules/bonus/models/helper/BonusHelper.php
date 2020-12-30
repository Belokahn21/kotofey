<?php

namespace app\modules\bonus\models\helper;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;

class BonusHelper
{
    public static function applyUserBonus(Order $order)
    {
        $orderSumm = OrderHelper::orderSummary($order);
        $bonuses = round($orderSumm * (UserBonus::PERCENT_AFTER_SALE / 100));

        self::addBonusUser($order->phone, $bonuses);
    }

    public static function addBonusUser($phone, $bonus)
    {
        $UserBonusEntity = UserBonus::findByPhone($phone);

        if (!$UserBonusEntity) return false;

        $UserBonusEntity->count += $bonus;

        if ($UserBonusEntity->validate() && $UserBonusEntity->update()) return true;

        return false;

    }
}