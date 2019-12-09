<?php

namespace app\models\helpers;


use app\models\entity\Order;
use app\models\entity\OrdersItems;

class OrderHelper
{
	public static function orderSummary($order_id)
	{
		return OrdersItems::find()->where(['order_id' => $order_id])->sum('price');
	}
}