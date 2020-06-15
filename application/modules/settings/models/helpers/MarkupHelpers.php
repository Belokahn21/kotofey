<?php

namespace app\modules\settings\models\helpers;

use app\models\entity\SiteSettings;
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
}