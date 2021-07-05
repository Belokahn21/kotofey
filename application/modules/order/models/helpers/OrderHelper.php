<?php

namespace app\modules\order\models\helpers;

use app\modules\catalog\models\entity\ProductTransferHistory;
use app\modules\catalog\models\helpers\ProductTransferHistoryHelper;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
use app\modules\payment\models\entity\Payment;
use app\modules\promocode\models\entity\Promocode;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class OrderHelper
{
    public static function containItemsWithDiscountPrice(Order $order)
    {
        foreach ($order->items as $item) {
            if ($item->discount_price) return true;
        }

        return false;
    }

    public static function isEmptyItem(OrdersItems $item)
    {
        return empty($item->name) && empty($item->price) && empty($item->count);
    }

    public static function rotate($params = [])
    {
        $out = 0;
        $orders = Order::find()->where(['is_paid' => true, 'is_close' => true]);

        if ($params) {
            foreach ($params as $block_params) {
                $orders->andWhere($block_params);
            }
        }

        foreach ($orders->all() as $order) {
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

        $summ = self::applyDiscountToAmount($order, $summ);

        return $summ;
    }

    public static function applyDiscountToAmount(Order $order, $summ)
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

            $status_model = OrderStatus::findOne($order->status);
            if ($status_model) {
                return $status_model->name;
            }
        }

        return 'В обработке';
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

    /* оборот заказа */
    public static function income(Order $order)
    {
        $out = 0;

        foreach ($order->items as $item) {
            $out += $item->count * $item->price;
        }

        return $out;
    }

    public static function marginalityAllOrder($params = [])
    {
        $outAmount = 0;
        $orders = Order::find()->where(['is_paid' => true, 'is_close' => true]);

        if ($params) {
            foreach ($params as $block_params) {
                $orders->andWhere($block_params);
            }
        }

        foreach ($orders->all() as $order) {
            $outAmount += self::marginality($order);
        }

        return $outAmount;
    }

    /* прибыль заказа */
    public static function marginality(Order $order)
    {
        $out_summ = 0;

        foreach ($order->items as $item) {
            $out_summ += (($item->discount_price ? $item->discount_price : $item->price) - $item->purchase) * $item->count;
        }

        if ($order->discount) $out_summ = self::applyDiscountToAmount($order, $out_summ);
        if ($order->promocode) {
            if ($promo = Promocode::findOneByCode($order->promocode)) {
                $out_summ = self::applyDiscountToAmount($order, $promo->discount);
            }
        }

        return $out_summ;
    }


    public static function minusStockCount(Order $model)
    {
        $items = OrdersItems::find()->where(['order_id' => $model->id])->all();

        if (!$items) return false;

        /* @var $item OrdersItems */
        foreach ($items as $item) {

            if (!$item->product or ProductTransferHistoryHelper::isStockApplyTransfer($model, $item->product)) continue;

            $product = Product::findOne($item->product->id);

            if (!$product) continue;

            $product->scenario = Product::SCENARIO_STOCK_COUNT;

            if ($product->count > 0 && $product->count - $item->count >= 0) $product->count -= $item->count;


            if (!$product->validate()) {
                print_r($product->getErrors());
                exit();
            }

            if ($product->update()) {
                $obj = new ProductTransferHistory();
                $obj->order_id = $model->id;
                $obj->count = $item->count;
                $obj->product_id = $item->product->id;
                $obj->reason = "Списание {$item->name} в количестве {$item->count}шт. за заказ №{$model->id} от " . date('d.m.Y');

                if (!$obj->validate() || !$obj->save()) {
                    Debug::p($obj->getErrors());
                    exit();
                }
            }
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