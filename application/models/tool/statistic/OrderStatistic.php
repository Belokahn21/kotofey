<?php

namespace app\models\tool\statistic;


use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\models\entity\Product;
use yii\helpers\ArrayHelper;

class OrderStatistic extends Product
{

    /*Доход с одного заказа*/
	public static function orderSummary($order_id)
	{
		return OrdersItems::find()->where(['order_id' => $order_id])->sum('price');
	}
}