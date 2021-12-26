<?php

namespace app\commands;

use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\OrderDate;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\pets\models\entity\Pets;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        foreach (OrderDate::find()->all() as $item) {
            $item->date = date('Y-m-d', strtotime($item->date));

            if (!$item->validate() || !$item->update()) {
                Debug::p($item->id);
            }
        }
//        foreach (Pets::find()->all() as $pet) {
//            $pet->birthday = date('Y-m-d', strtotime($pet->birthday));
//
//            if ($pet->validate() && $pet->update() !== false) {
//                echo $pet->name . PHP_EOL;
//            }
//        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
