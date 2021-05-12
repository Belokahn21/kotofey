<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Debug;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
//        $sql = 'update `orders` set `status_id`=:status, `is_close`=1, `is_` where `created_at` <= :time';
        $sql = 'select * from `order` where `created_at` <= :time';

        $q = \Yii::$app->db->createCommand($sql, [
//            ':status' => 1,
            ':time' => strtotime('01.02.2021')
        ]);

        foreach ($q->queryAll() as $row) {
            if (!$row['is_cancel']) {
                \Yii::$app->db->createCommand('update `order` set `status`=:status, `is_close`=1, `is_paid`=1 where `id`=:id', [
                    ':status' => 3,
                    ':id' => $row['id'],
                ])->query();
            }else{
                \Yii::$app->db->createCommand('update `order` set `status`=:status, `is_close`=1 where `id`=:id', [
                    ':status' => 3,
                    ':id' => $row['id'],
                ])->query();
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
