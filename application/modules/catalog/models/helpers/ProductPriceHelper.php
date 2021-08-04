<?php

namespace app\modules\catalog\models\helpers;

use Yii;
use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\entity\PriceProduct;

class ProductPriceHelper
{
    public static function saveItems(int $product_id)
    {
        $count = count(Yii::$app->request->post('PriceProduct', []));

        $items = [new PriceProduct()];

        for ($i = 1; $i < $count; $i++) {
            $items[] = new PriceProduct();
        }

        PriceProduct::deleteAll(['product_id' => $product_id]);

        if (PriceProduct::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $item) {

                if (empty($item->value)) continue;

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