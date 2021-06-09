<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun($name=null)
    {
        if($name==null){$name='banters';}
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

            $product->status_id = Product::STATUS_WAIT;
            if ($product->validate() && $product->update()) {
                echo "ok: " . $product->name . PHP_EOL;
            }

//            if (ProductPropertiesValuesHelper::savePropertyValue($product->id, 20, '230')) {
////            if (ProductPropertiesValuesHelper::removePropertyValue($product->id, 20)) {
//                echo "ok: " . $product->name . PHP_EOL;
//            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
