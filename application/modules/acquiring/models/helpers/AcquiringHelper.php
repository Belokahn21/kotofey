<?php

namespace app\modules\acquiring\models\helpers;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\models\entity\Order;

class AcquiringHelper
{

    public static function getInstance()
    {
        return new AcquiringHelper();
    }

    public function paymentLink(Order $order)
    {
        $history = AcquiringOrder::findOne(['order_id' => $order->id]);

        if ($history) return "https://3dsec.sberbank.ru/payment/merchants/sbersafe_sberid/payment_ru.html?mdOrder=$history->identifier_id";

        return false;
    }
}