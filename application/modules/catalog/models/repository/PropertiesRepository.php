<?php


namespace app\modules\catalog\models\repository;

use Yii;
use app\modules\catalog\models\entity\Properties;

class PropertiesRepository
{
    public static function getAllProperties()
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Properties::find()->all();
        });
    }
}