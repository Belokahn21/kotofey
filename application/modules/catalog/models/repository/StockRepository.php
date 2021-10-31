<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\ProductStock;

class StockRepository
{
    public static function getValues(int $product_id, array $stock_ids)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $product_id . implode(',', $stock_ids), function () use ($product_id, $stock_ids) {
            return ProductStock::findAll(['product_id' => $product_id, 'stock_id' => $stock_ids]);
        });
    }
}