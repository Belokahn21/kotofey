<?php

namespace app\commands;

use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\Product;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find()->all();
        \Yii::$app->db->createCommand('truncate table `price_product`')->execute();


        foreach ($products as $product) {
            $priceList = [
                'purchase' => 'purchase',
                'sale' => 'price',
                'base' => 'base_price',
            ];

            foreach ($priceList as $key => $code) {
                $price_tmp = Price::findOneByCode($key);
                $value = $product->{$priceList[$key]};
                if ($price_tmp && !empty($value)) {
                    $purchase = new PriceProduct();
                    $purchase->price_id = $price_tmp->id;
                    $purchase->product_id = $product->id;
                    $purchase->value = $value;
                    if (!empty($purchase->product_id) && $purchase->validate() && $purchase->save()) {
                        Debug::p($purchase->id . '-' . $purchase->product_id . '-' . $purchase->price_id . '-' . $purchase->value);
                        echo PHP_EOL;
                    } else {
                        Debug::p($purchase->getErrors());
                    }
                }
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
