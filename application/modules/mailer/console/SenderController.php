<?php

namespace app\modules\mailer\console;

use app\modules\mailer\models\services\MailService;
use app\modules\order\models\entity\Order;
use app\modules\promocode\models\TakeAvailableService;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\System;
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
            ->select(['id', 'email', 'phone', 'created_at'])
            ->where(['!=', 'email', ''])
            ->andWhere(['in', 'created_at', Order::find()->select('MAX(created_at)')->groupBy('email')])
            ->andWhere(['<', 'created_at', strtotime('-2 month')])
            ->andWhere(['not in', 'email', ArrayHelper::getColumn(Subscribes::find()->where(['active' => 0])->all(), 'email')])
            ->limit(5);
        $orders = $orders->all();


        foreach ($orders as $order) {
            $take_serivce = new TakeAvailableService($order->phone);
            $promo_code = $take_serivce->getPromo();

            $es = new MailService();
            $es->sendEvent($module->remember_event_id, [
                'EMAIL_TO' => 'popugau@gmail.com',
                'EMAIL_FROM' => 'sale@kotofey.store',
                'LINK_SITE' => 'https:kotofey.store/catalog/',
                'PROMOCODE' => $promo_code->code,
                'DISCOUNT' => $promo_code->discount,
            ]);
        }
    }
}