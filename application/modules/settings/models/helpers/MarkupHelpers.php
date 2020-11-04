<?php

namespace app\modules\settings\models\helpers;

use app\modules\catalog\models\entity\Product;
use app\modules\site_settings\models\entity\SiteSettings;
use Yii;

class MarkupHelpers
{
    const MARKUP_KEY = 'markup_price';

    public static function getCurrentMarkupProduct()
    {
        $cookies = Yii::$app->request->cookies;
        $percent = $cookies->getValue(self::MARKUP_KEY, SiteSettings::findByCode('saleup')->value);

        return $percent;
    }

    public static function applyMarkup(Product &$model, $markup)
    {
        $model->price = round($model->purchase + $model->purchase / 100 * $markup);
    }
}