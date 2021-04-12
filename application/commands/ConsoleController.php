<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\settings\models\helpers\MarkupHelpers;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {

        $models = Product::find()
            ->where("`price`=`purchase`")
            ->orWhere('round((price / purchase) * 100 - 100) < :markup', [
                ':markup' => 15
            ])->all();
        foreach ($models as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            MarkupHelpers::applyMarkup($product, 30);


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
