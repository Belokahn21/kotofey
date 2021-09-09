<?php


$order = \app\modules\order\models\entity\Order::findOne(256);

$ns = new \app\modules\order\models\service\NotifyService();
$ns->notifyOrderComplete($order);