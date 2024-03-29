<?php

namespace app\modules\acquiring\models\helpers;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\models\entity\Order;
use app\modules\payment\models\services\acquiring\auth\SberbankAuthBasic;
use app\modules\payment\models\services\acquiring\banks\Sberbank;
use app\modules\payment\models\services\acquiring\AcquiringTerminalService;

class AcquiringHelper
{

    public static function getInstance()
    {
        return new AcquiringHelper();
    }

    public function productionPaymentLink(Order $order)
    {
        $history = AcquiringOrder::findOne(['order_id' => $order->id]);

        if ($history) return "https://securepayments.sberbank.ru/payment/merchants/sbersafe_sberid/payment_ru.html?mdOrder=$history->identifier_id";

        return false;
    }

    public function developPaymentLink(Order $order)
    {
        $history = AcquiringOrder::findOne(['order_id' => $order->id]);

        if ($history) return "https://3dsec.sberbank.ru/payment/merchants/sbersafe_sberid/payment_ru.html?mdOrder=$history->identifier_id";

        return false;
    }
}