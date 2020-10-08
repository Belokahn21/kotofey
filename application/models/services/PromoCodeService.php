<?php

namespace app\models\services;


use app\modules\site_settings\models\entity\SiteSettings;

class PromoCodeService
{
    public static function isActive()
    {
        if ($is_active_from_db = SiteSettings::findByCode('is_active_promocode')) {
            return (boolean)$is_active_from_db->value;
        } else {
            return \Yii::$app->params['use_promocode'];
        }
    }
}