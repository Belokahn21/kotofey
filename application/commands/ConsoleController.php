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
        $products = Product::find()->where(['vendor_id' => Vendor::VENDOR_ID_PURINA])->all();
        foreach ($products as $product) {
            $product->status_id = Product::STATUS_DRAFT;
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

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
