<?php

namespace app\modules\basket\models\helpers;


use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\modules\order\models\entity\OrdersItems;

class BasketHelper
{
    public static function getItemPrice(OrdersItems $item)
    {
        $summary_price = $item->price;
        if ($item->weight) {
            $product_weight = ProductPropertiesHelper::getProductWeight($item->product_id);
            $price_by_one_position_weight = round($item->price / $product_weight);
            $summary_price = round($price_by_one_position_weight * ($item->weight / 1000));
        }

        return $summary_price;
    }
}