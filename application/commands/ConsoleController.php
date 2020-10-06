<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductSync;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;
use yii\helpers\Json;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find();
        $products->where(['vendor_id' => Vendor::VENDOR_ID_PURINA]);
        echo "Найдено: " . $products->count();
        $products = $products->all();

        foreach ($products as $product) {

            $product->status_id = Product::STATUS_DRAFT;


            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
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
