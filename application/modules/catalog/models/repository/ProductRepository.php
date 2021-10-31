<?php


namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\Product;

class ProductRepository
{
    public static function getAllProductsSortedDesc()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
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