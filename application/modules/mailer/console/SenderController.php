<?php

namespace app\modules\mailer\console;

use app\modules\mailer\models\services\MailService;
use app\modules\order\models\entity\Order;
use app\modules\subscribe\models\entity\Subscribes;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class SenderController extends Controller
{
    public function actionRemember()
    {
        $module = \Yii::$app->getModule('mailer');

        if (!$module || empty($module->remember_event_id)) return false;

        $orders = Order::find()
            ->select(['id', 'email', 'created_at'])
            ->where(['!=', 'email', ''])
            ->andWhere(['in', 'created_at', Order::find()->select('MAX(created_at)')->groupBy('email')])
            ->andWhere(['<', 'created_at', strtotime('-2 month')])
            ->andWhere(['not in', 'email', ArrayHelper::getColumn(Subscribes::find()->where(['active' => 0])->all(), 'email')]);
        $orders = $orders->all();


        foreach ($orders as $order) {
            $promo_code = rand();

            $es = new MailService();
            $es->sendEvent($module->remember_event_id, [
                'PROMO_CODE' => $promo_code
            ]);
        }
    }
}