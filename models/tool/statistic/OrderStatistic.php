<?php

namespace app\models\tool\statistic;


use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\models\entity\Product;
use yii\helpers\ArrayHelper;

class OrderStatistic extends Product
{

	public static function tableName()
	{
		return "order";
	}

	/*Доход с одного заказа*/
	public static function orderSummary($order_id)
	{
		return OrdersItems::find()->where(['order_id' => $order_id])->sum('price');
	}

	/*Доход*/
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