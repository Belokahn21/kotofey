<?php


namespace app\modules\pets\models\helpers;


use app\modules\pets\models\entity\Pets;

class PetsHelper
{
    public static function getImage(Pets $model)
    {
        return '/upload/' . $model->avatar;
    }

    public static function isOverLimit(int $user_id)
    {
        if (\Yii::$app->user->id == 1) return false;
        return Pets::find()->select('count(updated_at)')->where(['user_id' => $user_id])->groupBy('MONTH(FROM_UNIXTIME(updated_at)), YEAR(FROM_UNIXTIME(updated_at))')->count() >= 1;
    }
}