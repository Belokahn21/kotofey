<?php

namespace app\modules\marketplace\models\repository;

use Yii;
use app\modules\marketplace\models\entity\MarketplaceProduct;
use yii\caching\DbDependency;

class MarketplaceProductRepository
{
    public static function getAllForPlace(int $marketplace_id)
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $marketplace_id, function () use ($marketplace_id) {
            return MarketplaceProduct::findAll(['marketplace_id' => $marketplace_id]);
        }, Yii::$app->params['cache_time'], new DbDependency(['sql' => 'select count(`id`) from `marketplace_product` where `marketplace_id`="' . $marketplace_id . '"']));
    }
    public static function getAllForProduct($product_id)
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $product_id, function () use ($product_id) {
            return MarketplaceProduct::findAll(['product_id' => $product_id]);
        }, Yii::$app->params['cache_time'], new DbDependency(['sql' => 'select count(`id`) from `marketplace_product` where `product_id`="' . $product_id . '"']));
    }
}