<?php


namespace app\modules\order\models\service;

use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\DateDeliveryHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\helpers\OrdersItemsHelpers;

class OrderService
{
    public function createOrder()
    {
        if (!$order_id = OrderHelper::createOrder()) return false;

        $notifyService = new NotifyService();

        (new OrdersItemsHelpers())->saveItems($order_id);
        (new DateDeliveryHelper())->create($order_id);


        $notifyService->sendClientNotify(Order::findOne($order_id));
        return true;
    }

    public function deleteOrder()
    {
    }

    public function updateOrder()
    {
    }
}