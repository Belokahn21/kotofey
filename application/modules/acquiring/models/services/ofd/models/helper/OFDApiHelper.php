<?php


namespace app\modules\acquiring\models\services\ofd\models\helper;


use app\modules\order\models\entity\Order;

class OFDApiHelper
{
    const PAYMENT_TYPE_NAL = 0;     // наличка
    const PAYMENT_TYPE_BEZNAL = 1;  // безналичный расчет
    const PAYMENT_TYPE_AVANS = 2;     // предварительная оплата (аванс);
    const PAYMENT_TYPE_CREDIT = 3;     // предварительная оплата (кредит);
    const PAYMENT_TYPE_OTHER = 4;     // иная форма оплаты.

    public static function getPaymentType(Order $order)
    {
        switch ($order->payment_id) {
            case 1: //Оплатить на сайте
                return self::PAYMENT_TYPE_BEZNAL;
            case 2: // Наличка
                return self::PAYMENT_TYPE_NAL;
            case 3://Оплатить через терминал
                return self::PAYMENT_TYPE_BEZNAL;
            default:
                return self::PAYMENT_TYPE_OTHER;
        }
    }
}