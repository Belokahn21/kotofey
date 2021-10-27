<?php

namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\ProductCategory;

class ProductCategoryRepository
{
    public static function getCategory(int $category_id)
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__ . $category_id, function () use ($category_id) {
            return ProductCategory::findOne($category_id);
        });
    }
}