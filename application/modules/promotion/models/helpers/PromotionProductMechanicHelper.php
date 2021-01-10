<?php


namespace app\modules\promotion\models\helpers;


use app\modules\promotion\models\forms\PromotionProductMechanicsForm;

class PromotionProductMechanicHelper
{
    public static function isSkip(PromotionProductMechanicsForm $model)
    {
        return empty($model->promotion_mechanic_id) || empty($model->product_id);
    }
}