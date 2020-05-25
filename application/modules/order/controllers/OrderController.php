<?php

namespace app\modules\order\controllers;


use app\models\entity\OrderDate;
use app\models\entity\Payment;
use app\models\services\DeliveryTimeService;
use app\modules\delivery\models\entity\Delivery;
use app\modules\order\models\entity\Order;
use app\widgets\notification\Alert;
use yii\web\Controller;

class OrderController extends Controller
{
	public function actionIndex()
	{
		$order = new Order();
		$payment = Payment::findAll(['active' => true]);
		$delivery = Delivery::findAll(['active' => true]);
		$order_date = new OrderDate();
		$delivery_time = new DeliveryTimeService();

		if (\Yii::$app->request->isPost) {
			if ($order->load(\Yii::$app->request->post())) {
				if ($order->validate()) {
					if ($order->save()) {
						Alert::setSuccessNotify('Заказ успешно создан.');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('index', [
			'delivery' => $delivery,
			'delivery_time' => $delivery_time,
			'order' => $order,
			'order_date' => $order_date,
			'payment' => $payment,
		]);
	}
}