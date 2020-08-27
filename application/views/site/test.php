<?php
//$promo = \app\modules\promocode\models\entity\Promocode::findOneByCode('qwerty');
//$promo = \app\modules\promocode\models\entity\Promocode::findOneByCode('котофей');
//var_dump($promo->isAvailable());
//var_dump($promo->isLimit());

$order = new \app\modules\order\models\entity\Order();
$order->scenario = \app\modules\order\models\entity\Order::SCENARIO_CLIENT_BUY;
//$order->promocode = 'qwerty';
$order->promocode = 'котофей';
$order->phone = '89059858726';
$order->email = 'popugau@gmail.com';


var_dump($order->validate());
var_dump($order->getErrors());
var_dump($order->save());
?>