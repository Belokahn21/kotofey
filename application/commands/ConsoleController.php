<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $bank_olded = [];
        foreach (['inspector', 'бравекто', 'ошейник от блох'] as $phrase) {
            $products = Product::find()->andWhere(['not in', 'id', $bank_olded]);

            foreach (explode(' ', $phrase) as $text_line) {
                $products->andFilterWhere([
                    'or',
                    ['like', 'name', $text_line],
                    ['like', 'feed', $text_line]
                ]);
            }

            $products = $products->all();


            foreach ($products as $product) {

                $mech = new PromotionProductMechanics();
                $mech->product_id = $product->id;
                $mech->promotion_mechanic_id = 1;
                $mech->amount = 15;
                $mech->discountRule = 2;
                $mech->promotion_id = 31;

                if ($mech->validate() && $mech->save()) {
                    $bank_olded[] = $product->id;
                    echo $product->name . PHP_EOL;
                }
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
