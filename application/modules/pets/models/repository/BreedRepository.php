<?php

namespace app\modules\pets\models\repository;

use app\modules\pets\models\entity\Breed;
use yii\db\ActiveRecord;

class BreedRepository
{
    /**
     * @return ActiveRecord[]
     */
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Breed::find()->all();
        });
    }
}