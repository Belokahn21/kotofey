<?php

namespace app\modules\delivery\models\repository;

use app\modules\delivery\models\entity\Delivery;

class DeliveryRepository
{
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Delivery::find()->all();
        });
    }

    public static function getOne(int $id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () use ($id) {
            return Delivery::findOne($id);
        });
    }
}