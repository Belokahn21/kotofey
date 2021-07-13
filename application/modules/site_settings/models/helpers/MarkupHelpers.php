<?php

namespace app\modules\site_settings\models\helpers;

use app\modules\catalog\models\entity\Offers;

class MarkupHelpers
{
    public static function applyMarkup(Offers &$model, $markup)
    {
        $model->price = round($model->purchase + $model->purchase / 100 * $markup);
    }
}