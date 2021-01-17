<?php

namespace app\modules\bonus\models\entity;

use app\modules\order\models\entity\Order;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_bonus_history".
 *
 * @property int $id
 * @property boolean $is_active
 * @property int $sort
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
            [['bonus_account_id', 'count'], 'required'],
            [['is_active'], 'boolean'],
            [['bonus_account_id', 'count', 'order_id', 'created_at', 'updated_at', 'sort'], 'integer'],
            [['reason'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bonus_account_id' => 'ID бонус - аккаунта',
            'count' => 'Количество',
            'order_id' => 'ID заказа',
            'reason' => 'Причина',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function findOneByOrder(Order $order)
    {
        return static::findOne(['bonus_account_id' => $order->phone, 'order_id' => $order->id, 'is_active' => false]);
    }
}
