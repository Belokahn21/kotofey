<?php

namespace app\modules\basket\models\helpers;


use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\order\models\entity\OrdersItems;

class BasketHelper
{
    public static function getItemPrice(OrdersItems $item)
    {
        $summary_price = $item->price;
        if ($item->weight) {
            $product_weight = PropertiesHelper::getProductWeight($item->product_id);
            $price_by_one_position_weight = round($item->price / $product_weight);
            $summary_price = round($price_by_one_position_weight * ($item->weight / 1000));
        }

        return $summary_price;
    }

    public static function inBasket($product_id)
    {
        foreach (Basket::findAll() as $item) {
            if ($product = $item->getProduct()) {
                if ($product->id == $product_id) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function containVendor($vendor_id)
    {
        foreach (Basket::findAll() as $item) {
            if ($product = $item->getProduct()) {
                if ($product->vendor_id == $vendor_id) {
                    return true;
                } else {
                    continue;
                }
            }
        }
        return false;
    }
}