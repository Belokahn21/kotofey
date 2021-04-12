<?php


namespace app\modules\user\models\helpers;


use app\modules\user\models\entity\UserBilling;

class UserBillingHelper
{
    public static function getName(UserBilling $model)
    {
        return !empty($model->name) ? $model->name : 'Без названия';
    }

    public static function getAddress(UserBilling $model)
    {
        return sprintf("город %s, улица %s, дом %s, квартира %s", $model->city, $model->street, $model->home, $model->house);
    }
}