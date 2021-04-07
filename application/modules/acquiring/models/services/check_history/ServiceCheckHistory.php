<?php


namespace app\modules\acquiring\models\services\check_history;


use app\modules\acquiring\models\entity\AcquiringOrderCheck;

class ServiceCheckHistory
{
    public static function saveCheckHistory(int $order_id, string $check_id)
    {
        $historyCheck = new AcquiringOrderCheck();
        $historyCheck->order_id = $order_id;
        $historyCheck->identifier_id = $check_id;

        return $historyCheck->validate() && $historyCheck->save();
    }

    public static function hasCheckHistory(int $order_id)
    {
        return AcquiringOrderCheck::findOne(['order_id' => $order_id]) instanceof AcquiringOrderCheck;
    }
}