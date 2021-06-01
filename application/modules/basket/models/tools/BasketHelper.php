<?php

namespace app\modules\basket\models\tools;


use app\modules\basket\models\entity\Basket;

class BasketHelper
{
    public static function inBasket($product_id)
    {
        foreach (Basket::findAll() as $item) {
            if ($item->product) {
                if ($item->product->id == $product_id) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function containVendor($vendor_id)
    {
        foreach (Basket::findAll() as $item) {
            if ($item->product) {
                if ($item->product->vendor_id == $vendor_id) {
                    return true;
                } else {
                    continue;
                }
            }
        }
        return false;
    }
}