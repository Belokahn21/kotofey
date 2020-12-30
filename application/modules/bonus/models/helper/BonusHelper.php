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
        $bonuses = $orderSumm - UserBonus::PERCENT_AFTER_SALE;



    }
}