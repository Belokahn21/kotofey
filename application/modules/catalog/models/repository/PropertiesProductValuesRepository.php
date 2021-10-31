<?php


namespace app\modules\catalog\models\repository;

use Yii;
use app\modules\catalog\models\entity\PropertiesProductValues;

class PropertiesProductValuesRepository
{
    public static function collectValues(array $property_ids, int $product_id)
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $product_id . implode(',', $property_ids), function () use ($product_id, $property_ids) {
            return PropertiesProductValues::findAll(['product_id' => $product_id, 'property_id' => $property_ids]);
        });
    }
}