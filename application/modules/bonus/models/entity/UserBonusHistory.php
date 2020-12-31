<?php

namespace app\modules\bonus\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_bonus_history".
 *
 * @property int $id
 * @property int $bonus_account_id
 * @property int|null $count
 * @property int|null $order_id
 * @property string|null $reason
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UserBonusHistory extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['bonus_account_id'], 'required'],
            [['bonus_account_id', 'count', 'order_id', 'created_at', 'updated_at'], 'integer'],
            [['reason'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bonus_account_id' => 'Bonus Account ID',
            'count' => 'Count',
            'order_id' => 'Order ID',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
