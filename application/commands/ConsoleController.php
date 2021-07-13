<?php

namespace app\commands;

use app\modules\catalog\models\entity\Offers;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun($name = null)
    {
        if ($name == null) {
            $name = 'purina';
        }
        $products = Offers::find();
        foreach (explode(' ', $name) as $text_line) {
            $products->andFilterWhere([
                'or',
                ['like', 'name', $text_line],
                ['like', 'feed', $text_line]
            ]);
        }

        $products->orFilterWhere(['vendor_id' => Vendor::VENDOR_ID_PURINA]);

        $products = $products->all();
        foreach ($products as $product) {
            $name = $product->name;
            if ($product->delete()) {
                echo "ok: " . $name . PHP_EOL;
            }

//            if ($product->validate() && $product->update() !== false) {
//                echo "ok: " . $product->name . PHP_EOL;
//            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
