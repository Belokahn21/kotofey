<?php

namespace app\modules\promocode\models\events;

use app\modules\order\models\entity\Order;
use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\entity\PromocodeUser;

class Manegment
{
    public function applyCodeToUser(Order $order)
    {
        if (!$order->promocode) {
            return false;
        }

        $promocode = Promocode::findOneByCode($order->promocode);

        if (!$promocode) {
            $this->unsetPromocode($order);
            return false;
        }

        if ($promocode->isLimit()) {
            $this->unsetPromocode($order);
            return false;
        }

        if (!$promocode->isAvailable()) {
            $this->unsetPromocode($order);
            return false;
        }

        if (PromocodeUser::findOneByPhone($order->phone)) {
            $this->unsetPromocode($order);
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

    public function unsetPromocode(Order $order)
    {
        $order->scenario = Order::SCENARIO_DEFAULT;
        $order->promocode = null;
        if ($order->validate()) {
            return $order->update();
        }
    }
}