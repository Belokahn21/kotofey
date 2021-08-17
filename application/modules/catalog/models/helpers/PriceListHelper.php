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
}