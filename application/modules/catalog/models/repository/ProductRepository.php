<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\Product;

class ProductRepository
{
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Product::find()->select(['id', 'name'])->orderBy(['created_at' => SORT_DESC])->all();
        });
    }
}