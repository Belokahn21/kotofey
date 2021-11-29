<?php

namespace app\modules\order\models\repository;

use app\modules\order\models\entity\OrderStatus;

class OrderStatusRepository
{
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return OrderStatus::find()->all();
        });
    }

    public static function getOne(int $id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () use ($id) {
            return OrderStatus::findOne($id);
        });
    }
}