<?php


namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\NotifyAdmission;

class NotifyAdmissionHelper
{
    public static function isAlreadyObserver($product_id, $email)
    {
        return NotifyAdmission::findOne(['product_id' => $product_id, 'email' => $email]) instanceof NotifyAdmission;
    }
}