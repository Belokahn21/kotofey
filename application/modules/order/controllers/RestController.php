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

        $status = 200;

//        if (!$order->load(\Yii::$app->request->post()) || !$order->validate()) return false;

        $transaction = \Yii::$app->db->beginTransaction();

        if ($order->load(\Yii::$app->request->post())) {

            if (!\Yii::$app->user->isGuest) $order->user_id = \Yii::$app->user->id;

            if (!$order->validate()) {
                $transaction->rollBack();
                return false;
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
                $status = 500;
                $transaction->rollBack();
            }


//            $orderDate->order_id = $order->id;
//            if ($orderDate->load(\Yii::$app->request->post())) {
//                if (!$orderDate->validate() && !$orderDate->save()) {
//                    $status = 500;
//                    $transaction->rollBack();
//                }
//            }

            // save products
            $items = new OrdersItems();
            $items->order_id = $order->id;

            if (!$items->saveItems()) {
                var_dump($items->getErrors());
                $status = 500;
                $transaction->rollBack();
            }
        }


        $transaction->commit();

        return [
            'status' => $status
        ];
    }

    public function actionGet()
    {
        return Json::encode(Order::find()->all());
    }
}