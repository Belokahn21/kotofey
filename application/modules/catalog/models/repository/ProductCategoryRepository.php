<?php


namespace app\modules\catalog\models\repository;


use app\modules\catalog\models\entity\ProductCategory;

class ProductCategoryRepository
{
    public static function getOne(int $id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $id, function () use ($id) {
            return ProductCategory::findOne($id);
        });
    }
}