<?php

$fs = new \app\modules\acquiring\models\services\fiscalisation\FiscalisationService();
$order = \app\modules\order\models\entity\Order::findOne(560);

//$fs->sendCheckClientByEmail($order, 'popugau@gmail.com');
$fs->getCheckStatusByCheckId('2a3215cc-4be4-48f4-aef5-d95f4a7aa979 ');
$fs->getCheckStatusByOrderId($order->id);