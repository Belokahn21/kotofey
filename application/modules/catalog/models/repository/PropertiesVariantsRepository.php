<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\PropertiesVariants;

class PropertiesVariantsRepository
{
    public static function variantsByPropertyId(int $property_id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $property_id, function () use ($property_id) {
            return PropertiesVariants::find()->asArray(true)->select(['id', 'name'])->where(['property_id' => $property_id])->orderBy(['name' => SORT_ASC])->all();
        });
    }
}