<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderDate;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\service\NotifyService;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;
use app\modules\user\models\entity\UserBilling;
use yii\filters\Cors;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        $order = new $this->modelClass(['scenario' => Order::SCENARIO_CLIENT_BUY]);
        $orderDate = new OrderDate();
        $billing = new UserBilling();
        $items = new OrdersItems();
        $response = [
            'status' => 200,
        ];

        if (!$order->load(\Yii::$app->request->post())) {
            $response['status'] = 500;
            $response['errors'] = 'Данные в модель Order не были загружены';
            return $response;
        }

        if (!$order->validate()) {
            $response['status'] = 510;
            $response['errors'] = $order->getErrors();
            return $response;
        }

        if (!$order->save()) {
            $response['status'] = 510;
            $response['errors'] = $order->getErrors();
            return $response;
        }

        $items->order_id = $order->id;
        if (!$items->saveItems()) {
            $response['status'] = 530;
            $response['errors'] = $items->getErrors();
            return $response;
        }

//        if (!$billing->load(\Yii::$app->request->post()) || !$billing->validate()) {
//            $response['status'] = 530;
//            $response['errors'] = $billing->getErrors();
//            return $response;
//        }


        $ns = new NotifyService();
        $ns->sendClientNotify(Order::findOne($order->id));

        $response['data']['order'] = [
            'id' => $order->id,
            'status' => OrderHelper::getStatus($order),
            'delivery' => OrderHelper::getDelivery($order),
            'payment' => OrderHelper::getPayment($order),
            'created' => date('d.m.Y H:i:s', $order->created_at),
            'address' => (!$order->city ? '' : 'г. ' . $order->city) . (!$order->street ? '' : ', ул. ' . $order->street) . (!$order->number_home ? '' : ', д. ' . $order->number_home) . (!$order->entrance ? '' : ', п. ' . $order->entrance) . (!$order->floor_house ? '' : ', эт. ' . $order->floor_house) . (!$order->number_appartament ? '' : ', кв. ' . $order->number_appartament),
            'total' => PriceTool::format(OrderHelper::orderSummary($order)) . ' ' . Currency::getInstance()->show(),
        ];
        return $response;
    }

    public function actionDelete($id)
    {
        $model = $this->modelClass::findOne($id);

        if (!$model) return array(
            'status' => 500,
            'error' => 'Элемент не найден'
        );

        if ($model->delete()) {
            return [
                'status' => 500,
                'error' => 'Ошибка при удалении элемента',
                'errors' => $model->getErrors()
            ];
        }


        return [
            'status' => 200
        ];
    }
}