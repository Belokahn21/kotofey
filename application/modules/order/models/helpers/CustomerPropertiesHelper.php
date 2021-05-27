<?php

namespace app\modules\order\models\helpers;

use app\modules\order\models\entity\Order;

class CustomerPropertiesHelper
{
    public static function getCrossProperties()
    {
        $out = [];
        foreach ([Order::getTableSchema()->columns] as $model) {
            $out += array_keys($model);
        }
        return $out;
    }
}