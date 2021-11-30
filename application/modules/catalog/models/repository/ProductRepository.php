<?php


namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\Product;

class ProductRepository
{
    /**
     * @return Product
     */
    public static function getOne(int $product_id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $product_id, function () use ($product_id) {
            return Product::findOne(['id' => $product_id]);
        });
    }

    public static function getAllProductsSortedDesc()
    {
        return \Yii::$app->cache->getOrSet(md5(__CLASS__ . __METHOD__), function () {
            return Product::find()->orderBy(['created_at' => SORT_DESC])->all();
        });
    }

    public static function getStockOut()
    {

        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Product::find()->where(['>', 'count', 0])->all();
        });
    }
}