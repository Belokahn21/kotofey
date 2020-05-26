<?php

namespace app\modules\order\controllers;


use app\models\entity\OrderDate;
use app\models\entity\Payment;
use app\models\services\DeliveryTimeService;
use app\modules\delivery\models\entity\Delivery;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
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
			$transaction = \Yii::$app->db->beginTransaction();

			if ($order->load(\Yii::$app->request->post())) {
				if (!$order->validate()) {

					$transaction->rollBack();
					return false;

				}
				if (!$order->save()) {

					Alert::setErrorNotify("Ошибка при создании заказа.");
					$transaction->rollBack();
					return false;

				}


				// save products
				$items = new OrdersItems();
				$items->order_id = $order->id;

				if (!$items->saveItems()) {
					Alert::setErrorNotify("Товары не были сохранены. Заказ не создан.");
					$transaction->rollBack();
					return false;
				}
			}


			$transaction->commit();
			Alert::setSuccessNotify('Заказ успешно создан.');
			return $this->refresh();
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