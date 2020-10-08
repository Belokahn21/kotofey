<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\ProductOrder;

class ProductOrderHelper
{
    public static function getProductDelivery($product_id)
    {
        return ProductOrder::find()->where(['product_id' => $product_id])->one();
    }
}