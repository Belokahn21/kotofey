<?php

namespace app\modules\catalog\models\helpers;

class StockHelper
{
    public static function getValue(array $data, int $product_id, int $stock_id)
    {
        $value = false;
        foreach ($data as $item) {
            if ($product_id == $item->product_id && $stock_id == $item->stock_id) $value = $item->count;
        }
        return $value;
    }
}