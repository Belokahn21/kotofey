<?php

namespace app\modules\catalog\models\repository;

use Yii;
use app\modules\catalog\models\entity\Composition;
use app\modules\catalog\models\entity\CompositionProducts;

class CompositionRepository
{
    public static function getValues(int $product_id, array $composition_id)
    {
        return Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__ . implode(',', $composition_id), function () use ($product_id, $composition_id) {
            return CompositionProducts::findAll(['product_id' => $product_id, 'composition_id' => $composition_id]);
        });
    }

    public static function getAllCompositions()
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Composition::find()->all();
        });
    }

    public static function getAllActiveCompositions()
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Composition::find()->where(['is_active' => true])->all();
        });
    }

    public static function getAlreadyProducts()
    {
        return Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return CompositionProducts::find()->select(['product_id'])->groupBy('product_id')->all();
        });
    }
}