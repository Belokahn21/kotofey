<?php


namespace app\modules\payment\models\helper;


use app\modules\payment\models\entity\Payment;

class PaymentHelper
{

    public static function getImageUrl(Payment $model)
    {
        return '/upload/' . $model->image;
    }
}