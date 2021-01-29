<?php

namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\ProductTransferHistory;

class ProductTransferHistoryForm extends ProductTransferHistory
{
    public $controlTransfer;

    public static function tableName()
    {
        return ProductTransferHistory::tableName();
    }

    public function rules()
    {
        return [
            [['product_id', 'reason', 'count'], 'required'],
            [['count'], 'default' => 0],
            [['product_id', 'order_id', 'created_at', 'updated_at', 'count', 'controlTransfer'], 'integer'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'count' => 'Count',
            'controlTransfer' => 'Control transfer',
            'order_id' => 'Order ID',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}