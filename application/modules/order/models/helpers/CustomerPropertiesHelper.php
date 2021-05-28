<?php

namespace app\modules\order\models\helpers;

use app\modules\order\models\entity\Order;

class CustomerPropertiesHelper
{
    public static function getCrossProperties()
    {
        $out = [];
        foreach ([Order::getTableSchema()->columns] as $model) {
            foreach (array_keys($model) as $key) {
                $out[$key] = $key;
            }
        }
        return $out;
    }
}