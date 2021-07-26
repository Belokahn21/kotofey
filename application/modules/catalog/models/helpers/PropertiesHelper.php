<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\Product;
use yii\web\HttpException;

class PropertiesHelper
{
    public static function getProductWeight($product_id)
    {
        $cache = \Yii::$app->cache;
        $product = Product::findOne($product_id);

        if (!$product) {
            throw new HttpException(404, 'Элемент не найден');
        }

        $weight = $cache->getOrSet(sprintf('gpw:%s', $product_id), function () use ($product) {
            return PropertiesProductValues::findOne(['property_id' => 2, 'product_id' => $product->id]);
//            return SaveProductPropertiesValues::findOne(['property_id' => 2, 'product_id' => $product->id]);
        }, 3600 * 7 * 24);

        if ($weight) return $weight->value;

        return 0;
    }

    /**
     * @param Product $model
     * @param $property_id
     * @return false|PropertiesProductValues
     */
    public static function extractPropertyById(Product $model, $property_id)
    {
        foreach ($model->propsValues as $value) if ($value->property_id === $property_id) return $value;

        return false;
    }

    public static function extractAllPropertyById(Product $model, $property_id)
    {
        $values = [];

        foreach ($model->propsValues as $value) {
            if ($value->property_id === $property_id) {
                $values[] = $value;
            }
        }


        return $values;
    }
}