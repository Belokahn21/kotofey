<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find()->where(['vendor_id' => Vendor::VENDOR_ID_FORZA])->all();
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            $product->discount_price = $product->price - round(($product->price * 10) / 100);


            $obj = new ProductPropertiesValues();
            $obj->product_id = $product->id;
            $obj->property_id = 11;
            $obj->value = '230';
            $obj->save();



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
