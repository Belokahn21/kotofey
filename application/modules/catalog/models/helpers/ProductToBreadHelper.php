<?php

namespace app\modules\catalog\models\helpers;

use Yii;
use app\modules\catalog\models\entity\ProductToBreed;
use app\modules\site\models\tools\Debug;

class ProductToBreadHelper
{
    public static function saveItems(int $product_id)
    {
        $count = count(Yii::$app->request->post('ProductToBreed', []));

        $items = [new ProductToBreed()];

        for ($i = 1; $i < $count; $i++) {
            $items[] = new ProductToBreed();
        }

        ProductToBreed::deleteAll(['product_id' => $product_id]);

        if (ProductToBreed::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $counter => $item) {

                if (empty($item->animal_id) || empty($item->breed_id) || !is_numeric($counter)) continue;

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