<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\Offers;

class PriceHelper
{
    public static function getModelKeys()
    {
        $out = [];
        foreach ([Offers::getTableSchema()->columns] as $model) {
            foreach (array_keys($model) as $key) {
                $out[$key] = $key;
            }
        }
        return $out;
    }
}