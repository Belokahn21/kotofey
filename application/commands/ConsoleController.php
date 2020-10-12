<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find()->where(['vendor_id' => null])->all();
//        $products = Product::find()->where(['like', 'name', "hill's"])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            if (!is_numeric($product->code)) {
                continue;
            }

            if (substr($product->code, 0, 4) != '0000' and substr($product->code, 0, 5) != '00000') {
                continue;
            }

            $product->vendor_id = Vendor::VENDOR_ID_SIBAGRO;

            if ($product->validate()) {
                if ($product->update()) {
                    echo $product->code . "=" . $product->name;
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
