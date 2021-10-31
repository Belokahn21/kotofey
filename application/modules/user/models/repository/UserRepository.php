<?php

namespace app\modules\user\models\repository;

use app\modules\user\models\entity\User;

class UserRepository
{
    public static function getOne(int $id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () use ($id) {
            return User::findOne($id);
        });
    }
}