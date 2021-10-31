<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\PriceProduct;

class PriceRepository
{
    public static function getValues(int $product_id, array $price_ids)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $product_id . implode(',', $price_ids), function () use ($product_id, $price_ids) {
            return PriceProduct::findAll(['product_id' => $product_id, 'price_id' => $price_ids]);
        });
    }
}