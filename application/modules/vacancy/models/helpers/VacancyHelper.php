<?php

namespace app\modules\vacancy\models\helpers;


use app\modules\vacancy\models\entity\Vacancy;
use yii\helpers\Url;

class VacancyHelper
{
    public static function getDetailUrl(Vacancy $model)
    {
        return Url::to(['vacancy/view', 'id' => $model->slug]);
    }
}