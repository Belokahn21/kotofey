<?php

namespace app\modules\acquiring\models\entity;

use Yii;

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
    public function rules()
    {
        return [
            [['order_id', 'identifier_id'], 'required'],
            [['order_id', 'identifier_id', 'created_at', 'updated_at'], 'integer'],
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
}
