<?php

namespace app\modules\catalog\models\services;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPriceHistory;

class PriceHistoryService
{
    public static function hasChanges(int $product_id): bool
    {
        $product = Product::findOne($product_id);
        if (!$product) throw new \Exception('Товар не существует');

        if (!$last_history_change = ProductPriceHistory::find()->select('*, max(created_at)')->where(['product_id' => $product_id])->groupBy('id')->one()) return true;

        return intval($product->price) !== intval($last_history_change->value);
    }

    public static function saveHistoryElement(int $product_id, int $value)
    {
        if (!self::hasChanges($product_id)) return false;

        $model = new ProductPriceHistory();
        $model->product_id = $product_id;
        $model->value = $value;

        return $model->validate() && $model->save();
    }

    public static function updateHistoryElement(int $product_id, int $value)
    {
        if (!$model = self::getModel($product_id)) {
            return self::saveHistoryElement($product_id, $value);
        }
        $model->value = $value;

        return $model->validate() && $model->update() !== false;
    }

    public static function deleteHistoryElement(int $product_id)
    {
        $model = self::getModel($product_id);

        if (!$model) return false;

        return $model->delete();
    }

    public static function clear(int $product_id)
    {
        return ProductPriceHistory::deleteAll(['product_id' => $product_id]);
    }

    private static function getModel($product_id)
    {
        return ProductPriceHistory::findOne($product_id);
    }
}