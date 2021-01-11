<?php

namespace app\modules\order\models\helpers;

use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
use app\modules\payment\models\entity\Payment;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class OrderHelper
{
    public static function isEmptyItem(OrdersItems $item)
    {
        return empty($item->name) && empty($item->price) && empty($item->count);
    }

    public static function rotate()
    {
        $out = 0;
        $orders = Order::find()->where(['is_paid' => true, 'is_close' => true])->all();

        foreach ($orders as $order) {
            $items = $order->items;

            foreach ($items as $item) {
                $out += $item->price * $item->count;
            }
        }

        return $out;
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

    public static function orderSummary(Order $order)
    {
        $summ = 0;
        foreach ($order->items as $item) $summ += $item->count * ($item->discount_price ? $item->discount_price : $item->price);

        $summ = self::applyDiscount($order, $summ);

        return $summ;
    }

    public static function applyDiscount(Order $order, $summ)
    {
        if (!$order->discount) return $summ;

        if (is_numeric($order->discount)) return $summ += $order->discount;


        if (explode('%', $order->discount)) {
            $tmpDiscount = str_replace('%', '', $order->discount);

            return $summ + round($summ * ($tmpDiscount / 100));
        }


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

    public static function marginality($order_id = null, $noForce = true)
    {
        $out_summ = 0;
        $orders = Order::find();

        if ($order_id) {
            $orders->where(['id' => $order_id]);
        }

        $orders->andWhere(['is_cancel' => 0, 'is_paid' => $noForce]);

        $orders = $orders->all();

        foreach ($orders as $order) {
            foreach ($order->items as $item) $out_summ += ($item->price - $item->purchase) * $item->count;

            if ($order->discount) $out_summ = self::applyDiscount($order, $out_summ);
        }

        return $out_summ;
    }

    public static function minusStockCount(Order $model, $isMinus = true)
    {
        $items = OrdersItems::find()->where(['order_id' => $model->id])->all();

        if (!$items) {
            return false;
        }

        /* @var $item OrdersItems */
        foreach ($items as $item) {

            if (!$item->product) {
                continue;
            }

            $product = Product::findOne($item->product->id);

            if (!$product) {
                continue;
            }

            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            if ($isMinus) {
                if ($product->count > 0 && $product->count - $item->count >= 0) {
                    $product->count -= $item->count;
                }
            } else {
                $product->count += $item->count;
            }

            if (!$product->validate()) {
                print_r($product->getErrors());
            }

            $product->update();
        }

        return true;
    }

    /**
     * @var $items OrdersItems[]
     */
    public static function getWhatsappMessage($items)
    {
        $out = "";

        foreach ($items as $item) {
            $out .= $item->count . "шт. " . $item->product->name . "%0a";
        }

        return $out;
    }
}