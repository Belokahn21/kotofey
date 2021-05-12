<?php

namespace app\modules\order\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_tracking".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $order_id
 * @property string|null $ident_key
 * @property string|null $service_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class OrderTracking extends \yii\db\ActiveRecord
{
    const SERVICE_CDEK = 'cdek';
    const SERVICE_RUSSIAN_POST = 'ru_post';
    const SERVICE_DPD = 'dpd';

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['order_id'], 'required'],
            [['is_active', 'order_id', 'created_at', 'updated_at'], 'integer'],
            [['ident_key', 'service_id'], 'string', 'max' => 250],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'order_id' => 'Order ID',
            'ident_key' => 'Ident Key',
            'service_id' => 'Service',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findByOrderId($order_id)
    {
        return static::findOne(['order_id' => $order_id]);
    }

    public function listDeliveryServices()
    {
        return [
            self::SERVICE_CDEK => 'CDEK',
            self::SERVICE_DPD => 'DPD',
            self::SERVICE_RUSSIAN_POST => 'Почта России',
        ];
    }
}
