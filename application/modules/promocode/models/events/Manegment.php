<?php

namespace app\modules\promocode\models\events;

use app\modules\order\models\entity\Order;
use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\entity\PromocodeUser;

class Manegment
{
    public static function applyCodeToUser(Order $order)
    {
        if (!$order->promocode) {
            return false;
        }

        $promocode = Promocode::findOneByCode($order->promocode);

        if (!$promocode) {
            return false;
        }

        $promoToUser = new PromocodeUser();
        $promoToUser->code = $promocode->code;
        $promoToUser->phone = $order->phone;

        if ($promoToUser->validate()) {
            return $promoToUser->save();
        }

        return false;
    }
}