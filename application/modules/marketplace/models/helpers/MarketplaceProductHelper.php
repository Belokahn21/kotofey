<?php

namespace app\modules\marketplace\models\helpers;

use Yii;
use app\modules\site\models\tools\Debug;
use app\modules\marketplace\models\entity\MarketplaceProduct;

class MarketplaceProductHelper
{
    public static function getValue(array $values, int $product_id, int $marketplace_id)
    {
        $result = false;
        foreach ($values as $item) {
            if ($item->product_id == $product_id && $item->marketplace_id == $marketplace_id) $result = true;
        }
        return $result;
    }

    public static function saveItems(int $product_id)
    {
        $count = count(Yii::$app->request->post('MarketplaceProduct', []));

        $items = [new MarketplaceProduct()];

        for ($i = 1; $i < $count; $i++) {
            $items[] = new MarketplaceProduct();
        }

        MarketplaceProduct::deleteAll(['product_id' => $product_id]);

        if (MarketplaceProduct::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $counter => $item) {

                if ($item->marketplace_id == 0) continue;

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