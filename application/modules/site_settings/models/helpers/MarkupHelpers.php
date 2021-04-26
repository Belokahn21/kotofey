<?php

namespace app\modules\site_settings\models\helpers;

use app\modules\catalog\models\entity\Product;

class MarkupHelpers
{
    public static function applyMarkup(Product &$model, $markup)
    {
        $model->price = round($model->purchase + $model->purchase / 100 * $markup);
    }
}