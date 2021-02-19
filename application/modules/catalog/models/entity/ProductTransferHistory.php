<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_transfer_history".
 *
 * @property int $id
 * @property int $product_id
 * @property int $count
 * @property int|null $order_id
 * @property string $reason
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProductTransferHistory extends \yii\db\ActiveRecord
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
            [['product_id', 'reason', 'count'], 'required'],
            [['count'], 'default', 'value' => 0],
            [['user_id'], 'default', 'value' => \Yii::$app->user->identity->id],
            [['product_id', 'order_id', 'created_at', 'updated_at', 'count', 'user_id'], 'integer'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'count' => 'Count',
            'controlTransfer' => 'Control transfer',
            'order_id' => 'Order ID',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
