<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductSync;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {

        ProductSync::deleteAll();

        $products = Product::find()->where(['>', 'discount_price', 0])->all();

        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->discount_price = 0;

            if ($product->validate()) {
                if ($product->update()) {
                    echo $product->name . " - good" . PHP_EOL;
                }
            } else {
                print_r($product->getErrors());
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
