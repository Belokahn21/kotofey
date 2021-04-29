<?php

$order = \app\modules\order\models\entity\Order::findOne(579);

$ofd = new \app\modules\acquiring\models\services\ofd\OFDFermaService();
$ofd->sendCheckClientByEmail($order, 'popugau@gmail.com');