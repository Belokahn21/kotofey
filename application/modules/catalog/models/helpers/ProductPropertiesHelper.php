<?php

namespace app\modules\catalog\models\helpers;


use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
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

        $weight = $cache->getOrSet(sprintf('gpw:%s', $product_id), function () use ($product) {
            return SaveProductPropertiesValues::findOne(['property_id' => 2, 'product_id' => $product->id]);
        }, 3600 * 7 * 24);

        if ($weight) {
            return $weight->value;
        }

        return false;
    }

    public static function getAllProperties($product_id, $properties = array())
    {
        $out = [];
        $cache = \Yii::$app->cache;

//        $values = $cache->getOrSet(sprintf('gap:%s', $product_id), function () use ($product_id) {
//            return ProductPropertiesValues::find()->where(['product_id' => $product_id])->all();
//        });

        $values = SaveProductPropertiesValues::find()->where(['product_id' => $product_id]);

        if ($properties) $values->andWhere(['property_id' => $properties]);

        $values = $values->all();


        if ($values) {
            foreach ($values as $value) {
                $out[$value->property->id] = $value->getFinalValue();
            }
        }

        return $out;
    }
}