<?php

namespace app\modules\acquiring\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "acquiring_order_check".
 *
 * @property int $id
 * @property int $order_id
 * @property string $identifier_id ID чека
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class AcquiringOrderCheck extends \yii\db\ActiveRecord
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
            [['order_id', 'identifier_id'], 'required'],
            [['order_id', 'created_at', 'updated_at'], 'integer'],
            [['identifier_id'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'ID заказа',
            'identifier_id' => 'ID чека',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
