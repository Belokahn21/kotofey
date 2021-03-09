<?php


namespace app\modules\order\controllers;


use app\modules\bonus\models\helper\BonusHelper;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderDate;
use app\modules\order\models\entity\OrdersItems;
use app\widgets\notification\Alert;
use yii\helpers\Json;
use yii\rest\ActiveController;

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

    public function actionAdd()
    {
        $order = new Order();
        $orderDate = new OrderDate();
        $response = [
            'status' => 200
        ];

        if (!$order->load(\Yii::$app->request->post()) || !$order->validate()) return false;

        $transaction = \Yii::$app->db->beginTransaction();

        if ($order->load(\Yii::$app->request->post())) {


            if (!$order->validate()) {
                $transaction->rollBack();

                $response['status'] = 500;
                $response['errors'] = $order->getErrors();

                return Json::encode($response);
            }

            if ($module = \Yii::$app->getModule('bonus')) {
                if ($module->getEnable()) {
                    if ($order->bonus && $order->bonus > 0) {
                        BonusHelper::addHistory($order, $order->bonus * -1, 'Списание за заказ #' . $order->id, true);
                        $order->discount = $order->bonus * -1;
                    }
                }
            }
            if (!$order->save()) {
                $transaction->rollBack();

                $response['status'] = 500;
                $response['errors'] = $order->getErrors();
                return Json::encode($response);
            }


//            $orderDate->order_id = $order->id;
//            if ($orderDate->load(\Yii::$app->request->post())) {
//                if (!$orderDate->validate() && !$orderDate->save()) {
//                    $transaction->rollBack();
//
//                    $response['status'] = 500;
//                    $response['errors'] = $orderDate->getErrors();
//                    return Json::encode($response);
//                }
//            }

            // save products
            $items = new OrdersItems();
            $items->order_id = $order->id;

            if (!$items->saveItems()) {
                $transaction->rollBack();

                $response['status'] = 500;
                $response['errors'] = $items->getErrors();
                return Json::encode($response);
            }
        }

        $transaction->commit();

        return Json::encode($response);
    }

    public function actionGet()
    {
        return Json::encode(Order::find()->all());
    }
}