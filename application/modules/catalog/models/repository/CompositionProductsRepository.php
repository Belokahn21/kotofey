<?php


namespace app\modules\catalog\models\repository;

use app\modules\catalog\models\entity\CompositionProducts;
use app\modules\catalog\models\entity\CompositionType;

class CompositionProductsRepository
{
    public static function getCompositProducts()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return CompositionProducts::find()->select(['product_id'])->groupBy('product_id')->all();
        });
    }

    public static function getTypesByIds(array $list_group_id)
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__ . implode(',', $list_group_id), function () use ($list_group_id) {
            return CompositionType::find()->where(['id' => $list_group_id])->all();
        });
    }
}