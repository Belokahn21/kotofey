<?php

namespace app\modules\order\models\repository;


use app\modules\order\models\entity\Customer;

class CustomerRepository
{
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__, function () {
            return Customer::find()->all();
        });
    }
}