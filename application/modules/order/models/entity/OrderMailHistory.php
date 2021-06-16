<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_mail_history".
 *
 * @property int $id
 * @property int $order_id
 * @property int $event_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class OrderMailHistory extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['order_id', 'event_id'], 'required'],
            [['order_id', 'event_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'ID заказа',
            'event_id' => 'ID письма',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function findByOrderId(int $order_id)
    {
        return static::findOne(['order_id' => $order_id]);
    }
}
