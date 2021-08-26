<?php

namespace app\commands;

use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\Product;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find()->where(['>', 'count', 0])->all();

        foreach ($products as $product) {
            $product->count = 0;
            $product->scenario = Product::SCENARIO_STOCK_COUNT;

            if ($product->validate() && $product->update()) {
                echo $product->name . PHP_EOL;
            } else {
                Debug::p($product->getErrors());
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
