<?php

namespace app\modules\bonus\models\repository;

use app\modules\bonus\models\entity\UserBonusHistory;

class UserBonusHistoryRepository
{
    public static function getUserBonus(int $phone)
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__ . $phone, function () use ($phone) {
            return UserBonusHistory::find()->where(['bonus_account_id' => $phone])->sum('count');
        });
    }
}