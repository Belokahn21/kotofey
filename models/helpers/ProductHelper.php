<?php

namespace app\models\helpers;


use app\models\entity\Product;

class ProductHelper
{
    public static function getPriceByWeight(Product $product, $weight)
    {
        $product_weight = ProductPropertiesHelper::getProductWeight($product->id);
        $summary_price = 0;
        if (!$product_weight) {
            return false;
        }

        $price_by_one_position_weight = round($product->price / $product_weight);
        $summary_price = round($price_by_one_position_weight * ($weight / 1000));

        return $summary_price;
    }
}