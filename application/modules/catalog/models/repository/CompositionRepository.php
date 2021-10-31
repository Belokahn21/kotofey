<?php

namespace app\modules\catalog\models\repository;

use Yii;
use app\modules\catalog\models\entity\Composition;
use app\modules\catalog\models\entity\CompositionProducts;

class CompositionRepository
{
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