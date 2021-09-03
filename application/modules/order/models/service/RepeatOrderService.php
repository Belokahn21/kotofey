<?php

namespace app\modules\order\models\service;

use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;

class RepeatOrderService
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function doRepeat()
    {
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