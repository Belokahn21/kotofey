<?php

namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductTransferHistory;

class ProductTransferHistoryForm extends ProductTransferHistory
{
    public static function tableName()
    {
        return ProductTransferHistory::tableName();
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

    public function beforeSave($insert)
    {
        if ($product = Product::findOne($this->product_id)) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->count += $this->count;
            if (!$product->validate() or !$product->update()) return false;
        }

        return parent::beforeSave($insert);
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