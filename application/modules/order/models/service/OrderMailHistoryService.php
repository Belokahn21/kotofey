<?php

namespace app\modules\order\models\service;


use app\modules\order\models\entity\OrderMailHistory;

class OrderMailHistoryService
{
    public static function add(int $order_id, int $event_id)
    {
        $history = new OrderMailHistory();
        $history->order_id = $order_id;
        $history->event_id = $event_id;
        return $history->validate() && $history->save();
    }
}