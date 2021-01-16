<?php


namespace app\modules\bonus\models\forms;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;

class UserBonusHistoryForm extends UserBonusHistory
{
    public static function tableName()
    {
        return UserBonusHistory::tableName();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($account = UserBonus::findOneByPhone($this->bonus_account_id)) {
            $account->count = +$this->count;
            if (!$account->validate() or !$account->update()) {
                return false;
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }
}