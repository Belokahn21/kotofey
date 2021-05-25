<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\order\models\entity\Order;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun($name)
    {
        //суперпремиум класс
//        $name = "Bosch";
//        $name = "sanabelle";
        $products = Product::find();
        foreach (explode(' ', $name) as $text_line) {
            $products->andFilterWhere([
                'or',
                ['like', 'name', $text_line],
                ['like', 'feed', $text_line]
            ]);
        }
        $products = $products->all();
        foreach ($products as $product) {
            if (ProductPropertiesValuesHelper::savePropertyValue($product->id, 20, '232')) {
                echo "ok: " . $product->name . PHP_EOL;
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
