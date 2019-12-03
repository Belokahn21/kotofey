<?php

namespace app\models\tool\statistic;


use app\models\entity\OrdersItems;
use app\models\entity\Product;

class OrderStatistic extends Product
{

	public static function tableName()
	{
		return "order";
	}

	public static function orderSummary($order_id)
	{
		return OrdersItems::find()->where(['order_id' => $order_id])->sum('price');
	}

	public static function income()
	{
		return OrdersItems::find()->sum('price');
	}

}