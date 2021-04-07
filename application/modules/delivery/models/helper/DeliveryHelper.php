<?php


namespace app\modules\delivery\models\helper;


use app\modules\delivery\models\entity\Delivery;

class DeliveryHelper
{
    public static function getImageUrl(Delivery $model)
    {
        return '/upload/' . $model->image;
    }
}