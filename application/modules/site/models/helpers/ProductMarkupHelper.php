<?php

namespace app\modules\site\models\helpers;


use app\modules\site_settings\models\entity\SiteSettings;

class ProductMarkupHelper
{
    const COOKIE_KEY_MARKUP = 'product_markup';

    public static function getProductMarkupFromCookie()
    {
        return \Yii::$app->request->cookies->getValue(ProductMarkupHelper::COOKIE_KEY_MARKUP, SiteSettings::findByCode('saleup')->value);
    }
}