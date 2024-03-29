<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_date".
 *
 * @property int $id
 * @property int $order_id
 * @property string $date
 * @property string $time
 * @property int $created_at
 * @property int $updated_at
 */
class OrderDate extends \yii\db\ActiveRecord
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
            [['date'], 'required', 'message' => 'Пожалуйста укажите день доставки'],

            [['time'], 'required', 'message' => 'Пожалуйста выберите время доставки'],

            [['order_id'], 'required'],

            [['order_id', 'created_at', 'updated_at'], 'integer'],
            [['date', 'time'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'ID заказа',
            'date' => 'День',
            'time' => 'Время',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
        ];
    }

    public static function findOneByOrderId($order_id)
    {
        return static::findOne(['order_id' => $order_id]);
    }
}
