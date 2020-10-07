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
//        $products->where(['vendor_id' => Vendor::VENDOR_ID_PURINA]);
        $products->where(['like', 'name', 'сибирская кошка']);
        $products->orWhere(['like', 'name', 'brit premium']);
        $products->orWhere(['like', 'name', 'brit premium']);
        echo "Найдено: " . $products->count();
        $products = $products->all();

        foreach ($products as $product) {

            $product->vendor_id = Vendor::VENDOR_ID_SIBAGRO;


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
