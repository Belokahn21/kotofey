<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\CompositionProducts;
use app\modules\catalog\models\entity\ProductStock;
use app\modules\site\models\tools\Debug;
use Yii;

class CompositionProductHelper
{
    public static function saveItems(int $product_id)
    {
        $count = count(Yii::$app->request->post('CompositionProducts', []));

        $items = [new CompositionProducts()];

        for ($i = 1; $i < $count; $i++) {
            $items[] = new CompositionProducts();
        }

        CompositionProducts::deleteAll(['product_id' => $product_id]);

        if (CompositionProducts::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $item) {

                if (empty($item->value)) continue;

                $item->product_id = $product_id;
                if (!$item->validate() || !$item->save()) {
                    Debug::p($item);
                    Debug::p($item->getErrors());
                    exit();
                    return false;
                }
            }
        }
        return true;
    }
}