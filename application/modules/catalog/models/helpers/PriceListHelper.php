<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\Product;

class PriceListHelper
{
    public static function getModelKeys()
    {
        $out = [];
        foreach ([Product::getTableSchema()->columns] as $model) {
            foreach (array_keys($model) as $key) {
                $out[$key] = $key;
            }
        }
        return $out;
    }

    public static function getValue(array $data, int $product_id, int $price_id)
    {
        $value = false;

        foreach ($data as $item) {
            if ($item->product_id == $product_id && $price_id == $item->price_id) $value = $item;
        }

        return $value;
    }
}