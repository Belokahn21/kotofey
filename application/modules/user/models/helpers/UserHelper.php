<?php

namespace app\modules\user\models\helpers;


use app\modules\user\models\entity\User;

class UserHelper
{
    public static function getAvatar(User $model)
    {
        $module = \Yii::$app->getModule('user');
        return $module->avatarPath . $model->avatar;
    }
}