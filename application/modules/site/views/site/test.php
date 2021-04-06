<?php

$fs = new \app\modules\acquiring\models\services\fiscalisation\FiscalisationService();
$order = \app\modules\order\models\entity\Order::findOne(1);

$fs->sendCheckClientByEmail($order, 'popugau@gmail.com');