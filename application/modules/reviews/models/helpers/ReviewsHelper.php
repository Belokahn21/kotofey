<?php

namespace app\modules\reviews\models\helpers;


use app\modules\reviews\models\entity\Reviews;
use yii\helpers\ArrayHelper;

class ReviewsHelper
{
    public static function getStatus(Reviews $model)
    {
        return ArrayHelper::getValue($model->getStatusList(), $model->status_id);
    }
}