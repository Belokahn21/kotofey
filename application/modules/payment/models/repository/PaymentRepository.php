<?php

namespace app\modules\payment\models\repository;

use app\modules\payment\models\entity\Payment;

class PaymentRepository
{
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Payment::find()->all();
        });
    }

    public static function getOne(int $id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () use ($id) {
            return Payment::findOne($id);
        });
    }
}