<?php

namespace app\modules\catalog\models\services;

use app\modules\catalog\models\entity\ProductPriceHistory;

class PriceHistoryService
{
    public static function saveHistoryElement(int $product_id, int $value)
    {
        $model = new ProductPriceHistory();
        $model->product_id = $product_id;
        $model->value = $value;

        return $model->validate() && $model->save();
    }

    public static function updateHistoryElement(int $product_id, int $value)
    {
        $model = self::getModel($product_id);
        $model->value = $value;

        return $model->validate() && $model->update() !== false;
    }

    public static function deleteHistoryElement(int $product_id)
    {
        $model = self::getModel($product_id);

        if (!$model) return false;

        return $model->delete();
    }

    private static function getModel($product_id)
    {
        return ProductPriceHistory::findOne($product_id);
    }
}