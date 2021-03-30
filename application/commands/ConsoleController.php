<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {

        $products = Product::find()->orFilterWhere(['vendor_id' => Vendor::VENDOR_ID_MARS])
            ->orFilterWhere(['like', 'name', 'cesar'])
            ->orFilterWhere(['like', 'name', 'pedigree'])
            ->orFilterWhere(['like', 'name', 'dreamies'])
            ->orFilterWhere(['like', 'name', 'chappi'])
            ->orFilterWhere(['like', 'name', 'whiskas'])
            ->orFilterWhere(['like', 'name', 'kitekat'])
            ->orFilterWhere(['like', 'name', 'perfect fit'])
            ->all();

        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->status_id = Product::STATUS_DRAFT;
            $product->vendor_id = Vendor::VENDOR_ID_MARS;


            echo "item: " . $product->name . PHP_EOL;
            if ($product->validate() && $product->update()) {
                echo "Updated: " . $product->name . PHP_EOL;
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
