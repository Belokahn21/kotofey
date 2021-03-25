<?php

namespace app\modules\acquiring\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "acquiring_order".
 *
 * @property int $id
 * @property int $order_id
 * @property int $identifier_id ID в системе банков
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class AcquiringOrder extends \yii\db\ActiveRecord
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
            [['identifier_id'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'identifier_id' => 'Identifier ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findOneByBankId($id)
    {
        return static::findOne(['identifier_id' => $id]);
    }
}
