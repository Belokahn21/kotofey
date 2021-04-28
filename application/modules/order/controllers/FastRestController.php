<?php

namespace app\modules\order\controllers;

use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\Price;
use yii\rest\Controller;

class FastRestController extends Controller
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();

        $basketItem = new OrdersItems();

        if (!$basketItem->load($data) || !$basketItem->validate()) {
            $response['status'] = 500;
            $response['errors'] = 'Товар не положен в корзину';
            return $response;
        }

        if (!$product = Product::findOne($basketItem->product_id)) {
            $response['status'] = 500;
            $response['errors'] = 'Такого товара не существует';
            return $response;
        }

        $basketItem->name = $product->name;
        $basketItem->price = $product->getPrice();
        if ($discount = $product->getDiscountPrice()) $basketItem->discount_price = $discount;
        $basketItem->purchase = $product->purchase;

        $basket = new Basket();
        $basket->add($basketItem);


        $order = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_FAST]);
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

        Basket::clear();

        $response['data']['order'] = [
            'id' => $order->id,
            'status' => OrderHelper::getStatus($order),
            'delivery' => OrderHelper::getDelivery($order),
            'payment' => OrderHelper::getPayment($order),
            'created' => date('d.m.Y H:i:s', $order->created_at),
            'total' => Price::format(OrderHelper::orderSummary($order)) . ' ' . Currency::getInstance()->show(),
        ];
        return $response;
    }
}