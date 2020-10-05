<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductSync;
use yii\console\Controller;
use yii\helpers\Json;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find()->all();

        foreach ($products as $product) {
            $outImages = [];
            @$images = Json::decode($product->images);
            if (!$images) {
                continue;
            }

            $product->images = null;

            foreach ($images as $image) {
                $image = str_replace('/web/', '/', $image);


                if (@is_file(\Yii::getAlias('@app/web' . $image))) {
                    $outImages[] = $image;
                }
            }

            if ($outImages) {
                $product->image = $outImages;
            }


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
