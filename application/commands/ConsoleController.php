<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
//        $products = Product::find()->where(['vendor_id' => Vendor::VENDOR_ID_HILLS])->all();
        $products = Product::find()->where(['like', 'name', "hill's"])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            $product->price = $product->purchase + round($product->purchase * 15 / 100);

            if ($product->validate()) {
                if ($product->update()) {
                    echo $product->name;
                    echo PHP_EOL;
                }
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
