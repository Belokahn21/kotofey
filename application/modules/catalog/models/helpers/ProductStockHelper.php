<?php

namespace app\modules\catalog\models\helpers;

use Yii;
use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\entity\ProductStock;

class ProductStockHelper
{
    public static function saveItems(int $product_id)
    {
        $count = count(Yii::$app->request->post('ProductStock', []));

        $items = [new ProductStock()];

        for ($i = 1; $i < $count; $i++) {
            $items[] = new ProductStock();
        }

        ProductStock::deleteAll(['product_id' => $product_id]);

        if (ProductStock::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $item) {

                if (empty($item->count)) continue;

                $item->product_id = $product_id;
                if (!$item->validate() || !$item->save()) {
                    Debug::p($item);
                    Debug::p($item->getErrors());
                    return false;
                }
            }
        }
        return true;
    }
}