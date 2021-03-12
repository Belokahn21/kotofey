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

    public static function calcCurrentAge($birthday = "17-10-1985")
    {
        $dateOfBirth = $birthday;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y год и %m месяца');
    }
}