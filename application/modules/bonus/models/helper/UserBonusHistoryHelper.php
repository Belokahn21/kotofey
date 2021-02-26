<?php


namespace app\modules\bonus\models\helper;


use app\modules\bonus\models\entity\UserBonusHistory;

class UserBonusHistoryHelper
{
    public static function activateHistoryElement(UserBonusHistory $model)
    {
        $model->is_active = true;
        return $model->validate() && $model->update();
    }
}