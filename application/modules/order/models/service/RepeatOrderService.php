<?php

namespace app\modules\order\models\service;

use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
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
        $basket = new Basket();
        $order_items = $this->order->items;
        $model = new Order(['scenario' => Order::SCENARIO_CLIENT_BUY]);
        $new_order_items = new OrdersItems();

        foreach ($order_items as $order_item) {
            $order_item->order_id = null;
            $basket->add($order_item);
        }

        $model->setAttributes(ArrayHelper::toArray($this->order));
        if (!$model->validate() || !$model->save()) {
            return new \Exception($model->getErrors());
        }

        $new_order_items->order_id = $model->id;
        if (!$new_order_items->saveItems()) {
            return new \Exception($new_order_items->getErrors());
        }

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