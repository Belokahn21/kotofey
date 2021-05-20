<?php

namespace app\modules\user\models\helpers;


use app\modules\user\models\entity\User;

class UserHelper
{
    public static function getManagers()
    {
        return User::find()->leftJoin('auth_assignment as auth', ['auth.user_id' => 'id'])->where(['auth.item_name' => 'SaleManager'])->all();
    }

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

    public static function getFullName(User $user)
    {
        return implode(' ', [$user->first_name, $user->name, $user->last_name]);
    }
}