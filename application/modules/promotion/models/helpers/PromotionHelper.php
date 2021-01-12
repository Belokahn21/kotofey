<?php


namespace app\modules\promotion\models\helpers;


use app\modules\promotion\models\entity\Promotion;
use yii\helpers\Url;

class PromotionHelper
{
    public static function getDetailUrl(Promotion $model)
    {
        return Url::to(['/promotion/promotion/view', 'id' => $model->slug]);
    }
}