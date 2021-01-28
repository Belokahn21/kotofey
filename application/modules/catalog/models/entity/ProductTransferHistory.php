<?php

namespace app\modules\catalog\models\entity;

use Yii;

/**
 * This is the model class for table "product_transfer_history".
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $order_id
 * @property string $reason
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProductTransferHistory extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['product_id', 'reason'], 'required'],
            [['product_id', 'order_id', 'created_at', 'updated_at'], 'integer'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'order_id' => 'Order ID',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
