<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use yii\web\HttpException;

class ProductPropertiesHelper
{
    public static function getProductWeight($product_id)
    {
        $cache = \Yii::$app->cache;
        $product = Product::findOne($product_id);

        if (!$product) {
            throw new HttpException(404, 'Элемент не найден');
        }

        $weight = $cache->getOrSet('ppv-w', function () use ($product) {
            return ProductPropertiesValues::findOne(['property_id' => 2, 'product_id' => $product->id]);
        }, 3600 * 7 * 24);

        if ($weight) {
            return $weight->value;
        }

        return false;
    }
}