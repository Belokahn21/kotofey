<?php

namespace app\modules\marketplace\models\services;

use app\modules\catalog\models\entity\Product;
use app\modules\marketplace\models\entity\MarketplaceProductStatus;

class MarketplaceProductStatusService
{
    public static function addHistory(Product $model, int $task_id)
    {
        $obj = new MarketplaceProductStatus();
        $obj->product_id = $model->id;
        $obj->task_id = $task_id;

        return $obj->validate() && $obj->save();
    }
}