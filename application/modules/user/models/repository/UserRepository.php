<?php

namespace app\modules\user\models\repository;


use app\modules\user\models\entity\User;

class UserRepository
{
    public static function getUser(int $user_id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () use ($user_id) {
            return User::findOne($user_id);
        });
    }
}