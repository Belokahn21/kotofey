<?php

namespace app\modules\catalog\models\repository;

use Yii;
use app\modules\catalog\models\entity\Composition;

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
}