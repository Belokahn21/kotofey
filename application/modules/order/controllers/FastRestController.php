<?php

namespace app\modules\order\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\Controller;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrderHelper;

class FastRestController extends Controller
{
    public $modelClass = 'app\modules\order\models\entity\Order';

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


        $order = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_FAST]);
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

        $count = count(Yii::$app->request->post('OrdersItems', []));

        $items = [new OrdersItems()];
        for ($i = 1; $i < $count; $i++) {
            $items[] = new OrdersItems();
        }

        if (OrdersItems::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $item) {

                if (OrderHelper::isEmptyItem($item)) continue;

                $item->order_id = $order->id;
                if (!$item->validate() || !$item->save()) {
                    $response['status'] = 510;
                    $response['errors'] = $item->getErrors();
                    return $response;
                }
            }

        }

        $response['data']['order'] = [
            'id' => $order->id,
            'status' => OrderHelper::getStatus($order),
            'delivery' => OrderHelper::getDelivery($order),
            'payment' => OrderHelper::getPayment($order),
            'created' => date('d.m.Y H:i:s', $order->created_at),
            'total' => PriceTool::format(OrderHelper::orderSummary($order)) . ' ' . Currency::getInstance()->show(),
        ];
        return $response;
    }
}