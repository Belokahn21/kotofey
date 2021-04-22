<?php

namespace app\modules\acquiring\models\helpers;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\models\entity\Order;
use app\modules\payment\models\services\equiring\auth\SberbankAuthBasic;
use app\modules\payment\models\services\equiring\banks\Sberbank;
use app\modules\payment\models\services\equiring\EquiringTerminalService;

class AcquiringHelper
{

    public static function getInstance()
    {
        return new AcquiringHelper();
    }

    public function paymentLink(Order $order)
    {
        $history = AcquiringOrder::findOne(['order_id' => $order->id]);

        if ($history) return "https://securepayments.sberbank.ru/payment/merchants/sbersafe_sberid/payment_ru.html?mdOrder=$history->identifier_id";

        return false;
    }
}