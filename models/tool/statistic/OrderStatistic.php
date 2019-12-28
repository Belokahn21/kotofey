<?php

namespace app\models\tool\statistic;


use app\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\Product;

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
    public static function income()
    {
        return OrdersItems::find()->sum('price');
    }


    public static function marginality()
    {
        $out_summ = 0;
        $orders = Order::find()->all();

        foreach ($orders as $order) {
            $items = OrdersItems::find()->where(['order_id' => $order->id])->all();
            foreach ($items as $item) {
                $product = Product::findOne($item->product_id);
                if ($product) {
                    $out_summ += $product->price - $product->purchase;
                }
            }
        }

        return $out_summ;
    }

}