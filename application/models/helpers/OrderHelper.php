<?php

namespace app\models\helpers;

use app\modules\delivery\models\entity\Delivery;
use app\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
use app\models\entity\Payment;
use app\models\tool\Debug;
use yii\helpers\ArrayHelper;

class OrderHelper
{
	public static function isEmptyItem(OrdersItems $item)
	{
		return empty($item->name) && empty($item->price) && empty($item->count);
	}

	public static function orderPurchase($order_id)
	{
		$out = 0;

		$items = OrdersItems::find()->where(['order_id' => $order_id])->all();

		foreach ($items as $item) {

			if (static::isEmptyItem($item)) {
				continue;
			}

			if ($item->product) {
				$out += $item->count * $item->product->purchase;
			} else {
				$out += $item->count * $item->price;
			}
		}


		return $out;
	}

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

	public static function tableName()
	{
		return "order";
	}

	public static function income($order_id = null)
	{
		$out = 0;

		if ($order_id == null) {
			$order_id = ArrayHelper::getColumn(Order::find()->where(['is_cancel' => 0])->all(), 'id');
		}

		$items = OrdersItems::find()->where(['order_id' => $order_id])->all();

		foreach ($items as $item) {
			$out += $item->count * $item->price;
		}

		return $out;
	}

	public static function marginality($order_id = null)
	{
		$out_summ = 0;
		$orders = Order::find();

		if ($order_id) {
			$orders->where(['id' => $order_id]);
		}

		$orders->andWhere(['is_cancel' => 0]);

		$orders = $orders->all();

		foreach ($orders as $order) {
			$items = OrdersItems::find()->where(['order_id' => $order->id])->all();
			foreach ($items as $item) {
				$product = Product::findOne($item->product_id);
				if ($product) {
					$out_summ += ($product->price - $product->purchase) * $item->count;
				}

				if (empty($item->product_id)) {
					$out_summ += $item->price * $item->count;
				}
			}
		}

		return $out_summ;
	}
}