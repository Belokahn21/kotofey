<?php

namespace app\modules\order\models\service;

use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class RepeatOrderService
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function doRepeat()
    {
        if (!self::hasRepeat($this->order->id)) throw new \Exception('Заказ нельзя повторить.');
        $module = \Yii::$app->getModule('order');
        $basket = new Basket();
        $order_items = $this->order->items;
        $model = new Order(['scenario' => Order::SCENARIO_DEFAULT]);
        $new_order_items = new OrdersItems();

        foreach ($order_items as $order_item) {
            $_tmp = clone $order_item;
            $_tmp->order_id = null;
            $basket->add($_tmp);
        }

        $model->setAttributes(ArrayHelper::toArray($this->order));
        $model->status = $module->order_default_status_id;
        $model->is_paid = false;
        $model->is_skip = false;
        $model->is_close = false;
        $model->is_cancel = false;

        if (!$model->validate() || !$model->save()) throw new \Exception(Debug::modelErrors($model->getErrors()));

        $new_order_items->order_id = $model->id;
        if (!$new_order_items->saveItems()) throw new \Exception($new_order_items->getErrors());

        Basket::clear();
        return true;
    }

    public static function hasRepeat(int $order_id)
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . $order_id, function () use ($order_id) {
            $items = OrdersItems::findByOrderId($order_id);

            foreach ($items as $ordersItem) {
                if (!$ordersItem->product instanceof Product) {
                    return false;
                }
            }

            return true;
        });
    }
}