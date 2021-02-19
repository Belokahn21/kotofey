<?php


namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductTransferHistory;
use app\modules\order\models\entity\Order;

class ProductTransferHistoryHelper
{
    public static function isStockApplyTransfer(Order $model, Product $product)
    {
        return ProductTransferHistory::find()->where(['order_id' => $model->id, 'product_id' => $product->id])->one();
    }
}