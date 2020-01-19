<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_billing".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_billing_id
 * @property int $created_at
 * @property int $updated_at
 */
class OrderBilling extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_billing';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_billing_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Номер заказа',
            'user_billing_id' => 'Адрес доставки',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
