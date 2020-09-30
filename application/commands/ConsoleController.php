<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\catalog\models\entity\ProductSync;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
//        ProductSync::deleteAll();
//        $products = Product::find()->all();
//
//        foreach ($products as $product) {
//            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//            $product->article = rand(100000, 999999);
//
//            if ($product->validate()) {
//                if ($product->update()) {
//                    echo "good" . PHP_EOL;
//                }
//            } else {
//                print_r($product->getErrors());
//            }
//        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
