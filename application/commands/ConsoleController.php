<?php

namespace app\commands;

use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        \Yii::$app->db->createCommand('truncate table `migration`')->execute();
        \Yii::$app->db->createCommand("")->execute();



//        $products = Product::find()->where(['vendor_id' => Vendor::VENDOR_ID_FORZA])->all();
//        foreach ($products as $product) {
//            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//
//            $product->discount_price = null;
//
//            if ($product->validate()) {
//                if ($product->update()) {
//                    echo $product->code . "=" . $product->name;
//                    echo PHP_EOL;
//                }
//            }
//        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
