<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\order\models\entity\Order;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        \Yii::$app->db->createCommand('update `order` set `manager_id`=1')->execute();
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
