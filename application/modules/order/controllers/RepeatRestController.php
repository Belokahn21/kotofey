<?php

namespace app\modules\order\controllers;


use app\modules\logger\models\service\LogService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\service\NotifyService;
use app\modules\order\models\service\RepeatOrderService;
use yii\rest\Controller;

class RepeatRestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $order_id = \Yii::$app->request->post('order_id', false);

        if (!$order_id) throw new \Exception('Параметры не переданы.');

        if (!$order = Order::findOne($order_id)) throw new \Exception('Заказ не найден.');


        $service = new RepeatOrderService($order);
        try {
            $service->doRepeat();
        } catch (\Exception $exception) {
            return [
                'status' => 500,
                'text' => $exception->getMessage(),
            ];
        }

        return [
            'status' => 200,
        ];
    }

    public function actionIndex()
    {
    }

    public function actionDelete()
    {
    }
}