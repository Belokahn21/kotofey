<?php

namespace app\modules\catalog\models\entity;

use phpDocumentor\Reflection\Types\Self_;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_transfer_history".
 *
 * @property int $id
 * @property int $product_id
 * @property int $operation_id
 * @property int $count
 * @property int|null $order_id
 * @property string $reason
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProductTransferHistory extends \yii\db\ActiveRecord
{
    const CONTROL_TRANSFER_PLUS = 1;
    const CONTROL_TRANSFER_MINUS = 2;

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['product_id', 'reason', 'count', 'operation_id'], 'required'],

            [['count'], 'default', 'value' => 0],

            [['user_id'], 'default', 'value' => \Yii::$app->user->identity->id],

            [['product_id', 'order_id', 'created_at', 'updated_at', 'count', 'user_id', 'operation_id'], 'integer'],

            [['reason'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'ID товара',
            'operation_id' => 'ID операции',
            'user_id' => 'ID пользователя',
            'count' => 'Количество',
            'order_id' => 'ID заказа',
            'reason' => 'Причина',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getOperations()
    {
        return [
            self::CONTROL_TRANSFER_PLUS => 'Приход товара',
            self::CONTROL_TRANSFER_MINUS => 'Списание товара',
        ];
    }
}