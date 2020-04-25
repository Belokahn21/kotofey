<?php

namespace app\models\helpers;


use app\models\entity\Delivery;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
use app\models\entity\Payment;
use app\models\tool\Debug;

class OrderHelper
{
	public static function orderSummary($order_id)
	{
		$summ = 0;
		foreach (OrdersItems::find()->where(['order_id' => $order_id])->all() as $item) {
			$summ += $item->count * $item->price;
		}
		return $summ;
	}

	public static function getStatus(Order $order)
	{
		if ($order->status) {
			return OrderStatus::findOne($order->status)->name;
		}
		return 'Обрабатывается';
	}

	public static function getPayment(Order $order)
	{
		if ($order->payment_id) {
			return Payment::findOne($order->payment_id)->name;
		}
		return 'Не указано';
	}

	public static function getDelivery(Order $order)
	{
		if ($order->delivery_id) {
			return Delivery::findOne($order->delivery_id)->name;
		}
		return 'Не указано';
	}

	public static function isFirstOrder($user_id)
	{
		return Order::find()->where(['user_id' => $user_id])->count() == 1;
	}
}