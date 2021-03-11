<?php


namespace app\modules\order\controllers;


use app\modules\bonus\models\helper\BonusHelper;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderDate;
use app\modules\order\models\entity\OrdersItems;
use app\widgets\notification\Alert;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\HttpException;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    protected function verbs()
    {
        return [
            'get' => ['GET'],
            'add' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function actionAdd()
    {
        $order = new Order(['scenario' => Order::SCENARIO_CLIENT_BUY]);
        $orderDate = new OrderDate();
        $items = new OrdersItems();
        $response = [
            'status' => 200,
        ];

        if (!$order->load(\Yii::$app->request->post())) {
            $response['status'] = 500;
            $response['errors'] = 'Данные в модель Order не были загружены';
            return Json::encode($response);
        }

        if (!$order->validate() || !$order->save()) {
            $response['status'] = 510;
            $response['errors'] = $order->getErrors();
            return Json::encode($response);
        }

        $items->order_id = $order->id;
        if (!$items->saveItems()) {
            $response['status'] = 530;
            $response['errors'] = $items->getErrors();
            return Json::encode($response);
        }


        return Json::encode($response);
    }

    public function actionGet()
    {
        return Json::encode(Order::find()->all());
    }
}