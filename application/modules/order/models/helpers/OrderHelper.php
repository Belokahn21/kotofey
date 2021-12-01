<?php

namespace app\modules\order\models\helpers;

use app\modules\catalog\models\entity\ProductTransferHistory;
use app\modules\catalog\models\helpers\ProductTransferHistoryHelper;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
use app\modules\site\models\traits\ErrorTrait;
use app\modules\payment\models\entity\Payment;
use app\modules\promocode\models\entity\Promocode;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class OrderHelper
{
    use ErrorTrait;

    public function create(Order $model): Order
    {
        $data = \Yii::$app->request->post();

        if (!$model->load($data)) {
            throw new \Exception('Данные не загружены в модель Order');
        }

        if (!$model->validate()) {
            $this->setErrors($model->getErrors());
            throw new \Exception('Ошибка при валидации заказа: ' . Debug::modelErrors($model));
        }

        if (!$model->save()) {
            $this->setErrors($model->getErrors());
            throw new \Exception('Ошибка на этапе вызова метода save(); : ' . Debug::modelErrors($model));
        }


        return $model;
    }

    public function update(Order $model): Order
    {
        $data = \Yii::$app->request->post();

        if (!$model->load($data)) {
            throw new \Exception('Данные не загружены в модель Order');
        }

        if (!$model->validate()) {
            $this->setErrors($model->getErrors());
            throw new \Exception('Ошибка при валидации заказа: ' . Debug::modelErrors($model));
        }

        if ($model->update() === false) {
            $this->setErrors($model->getErrors());
            throw new \Exception('Ошибка на этапе вызова метода update(); : ' . Debug::modelErrors($model));
        }


        return $model;
    }

    public function updateOrder(string $scenario = Order::SCENARIO_DEFAULT): Order
    {
        $data = \Yii::$app->request->post();
        $model = new Order(['scenario' => $scenario]);

        if (!$model->load($data)) {
            throw new \Exception('Данные не загружены в модель Order');
        }

        if (!$model->validate()) {
            $this->setErrors($model->getErrors());
            throw new \Exception('Ошибка при валидации заказа: ' . Debug::modelErrors($model));
        }

        if (!$model->save()) {
            $this->setErrors($model->getErrors());
            throw new \Exception('Ошибка на этапе вызова метода save(); : ' . Debug::modelErrors($model));
        }


        return $model;
    }

    public static function containItemsWithDiscountPrice(Order $order)
    {
        foreach ($order->items as $item) {
            if ($item->discount_price) return true;
        }

        return false;
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

    public static function orderPurchase(Order $order)
    {
        $summ = 0;
        foreach ($order->items as $item) $summ += $item->count * ($item->purchase);

        return $summ;
    }

    public static function orderSummary(Order $order)
    {
        $summ = 0;
        foreach ($order->items as $item) $summ += $item->count * ($item->discount_price ? $item->discount_price : $item->price);

        $summ = self::applyDiscountToAmount($order, $summ);

        return $summ;
    }

    public static function applyDiscountToAmount(Order $order, int $summ)
    {

        if (!$order->discount) return $summ;

        if (is_numeric($order->discount)) return $summ + $order->discount;


        if (explode('%', $order->discount)) {
            $tmpDiscount = str_replace(['%', ' '], '', $order->discount);

            return $summ + round($summ * ($tmpDiscount / 100));
        }


        return $summ;
    }

    public static function applyPromocodeToAmount(Order $order, $summ)
    {
        if (!$order->promocodeEntity) return $summ;


        $tmpDiscount = $order->promocodeEntity->discount;
        if (explode('%', $order->promocodeEntity->discount)) {
            $tmpDiscount = str_replace('%', '', $order->promocodeEntity->discount);
        }


        return $summ - round($summ * ($tmpDiscount / 100));

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
        $minus = 0;
        $full_summary = self::orderSummary($order);
        $purchase = self::orderPurchase($order);

        if ($order->payment_id == Payment::PAYMENT_TERMINAL) $minus += round($full_summary * 0.01);
        if ($order->manager_id != 1) $minus += round($full_summary * 0.05);
        $minus += round(($full_summary - $purchase) * 0.15);

        return $full_summary - $purchase - $minus;
    }


    public static function minusStockCount(Order $model)
    {
        $items = OrdersItems::find()->where(['order_id' => $model->id])->all();

        if (!$items) return false;

        /* @var $item OrdersItems */
        foreach ($items as $item) {

            if (!$item->product or ProductTransferHistoryHelper::isStockApplyMinusTransfer($model, $item->product) or empty($item->count)) continue;

            $product = Product::findOne($item->product->id);

            if (!$product) continue;

            $product->scenario = Product::SCENARIO_STOCK_COUNT;

            if ($product->count > 0 && $product->count - $item->count >= 0) $product->count -= $item->count;


            if (!$product->validate()) {
                print_r($product->getErrors());
                exit();
            }

            if ($product->update() !== false) {
                $obj = new ProductTransferHistory();
                $obj->order_id = $model->id;
                $obj->count = $item->count;
                $obj->product_id = $item->product->id;
                $obj->operation_id = ProductTransferHistory::CONTROL_TRANSFER_MINUS;
                $obj->reason = "Списание {$item->name} в количестве {$item->count}шт. за заказ №{$model->id} от " . date('d.m.Y');

                if (!$obj->validate() || !$obj->save()) {
                    Debug::p($obj->getErrors());
                    exit();
                }
            }
        }

        return true;
    }

    public static function plusStockCount(Order $model): bool
    {

        if (!$items = $model->items) return false;

        /* @var $item OrdersItems */
        foreach ($items as $item) {

            if (!$item->product or ProductTransferHistoryHelper::isStockApplyPlusTransfer($model, $item->product)) continue;

            $product = Product::findOne($item->product->id);

            if (!$product || $product->count >= $item->count) continue;

            $product->scenario = Product::SCENARIO_STOCK_COUNT;

            $product->count += $item->count;

            if (!$product->validate()) {
                print_r($product->getErrors());
                exit();
            }

            if ($product->update() !== false) {
                exit();
                $obj = new ProductTransferHistory();
                $obj->order_id = $model->id;
                $obj->count = $item->count;
                $obj->operation_id = ProductTransferHistory::CONTROL_TRANSFER_PLUS;
                $obj->product_id = $item->product->id;
                $obj->reason = "Приход {$item->name} в количестве {$item->count}шт. по заказу №{$model->id}";

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