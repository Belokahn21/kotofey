<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\PropertiesVariants;

class PropertiesVariantsRepository
{
    public static function getVariantsByPropertyId($property_id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $property_id, function () use ($property_id) {
            return PropertiesVariants::find()->where(['property_id' => $property_id])->orderBy(['name' => SORT_ASC])->all();
        });
    }
}