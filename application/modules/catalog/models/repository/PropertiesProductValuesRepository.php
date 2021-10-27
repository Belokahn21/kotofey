<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\PropertiesProductValues;

class PropertiesProductValuesRepository
{
    public static function getAllValues($product_id, $property_id)
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__ . $product_id . $property_id, function () use ($product_id, $property_id) {
            return PropertiesProductValues::findAll([
                'product_id' => $product_id,
                'property_id' => $property_id
            ]);
        });
    }
    public static function getOneValue($product_id, $property_id)
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__ . $product_id . $property_id, function () use ($product_id, $property_id) {
            return PropertiesProductValues::findOne(['product_id' => $product_id, 'property_id' => $property_id]);
        });
    }
}