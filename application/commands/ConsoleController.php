<?php

namespace app\commands;

use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\PriceProduct;
use app\modules\catalog\models\entity\Product;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\pets\models\entity\Pets;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $models = Pets::find()->all();

        foreach ($models as $pet) {

            $pet->user_id = $pet->status_id;
            $pet->status_id = Pets::STATUS_ON;

            if ($pet->validate() && $pet->update() !== false) {
                echo $pet->name . PHP_EOL;
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
