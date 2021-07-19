<?php

namespace app\modules\mailer\console;

use app\modules\order\models\entity\Order;
use yii\console\Controller;

class EmailSenderController extends Controller
{
    public function actionRemember()
    {
        $orders = Order::find()
            ->select(['id', 'email', 'created_at'])
            ->where(['!=', 'email', ''])
            ->andWhere(['in', 'created_at', Order::find()->select('MAX(created_at)')->groupBy('email')])
            ->andWhere(['<', 'created_at', strtotime('-2 month')])
            ->asArray(true);


        $orders = $orders->all();


    }
}