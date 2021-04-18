<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
