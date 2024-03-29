<?php

namespace app\modules\user\models\helpers;


use app\modules\user\models\entity\UsersReferal;

class UserReferalHelper
{
    public static function countSummary($user_id)
    {
        return UsersReferal::find()->where(['key_called' => UsersReferal::findOneByUserId($user_id)->key])->sum('count_reward');
    }

    public static function countInvited($user_id)
    {
        return UsersReferal::find()->where(['key_called' => UsersReferal::findOneByUserId($user_id)->key])->count();
    }
}