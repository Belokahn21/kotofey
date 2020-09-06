<?php

use app\modules\order\models\entity\Order;
use app\models\tool\Debug;

$orders = array();
$phoneCustomer = Order::find()->select('phone')->all();

foreach ($phoneCustomer as $phone) {
    $orders[$phone->phone] = Order::find()->orderBy(['created_at' => SORT_ASC])->where(['phone' => $phone->phone])->all();
}


foreach ($orders as $phone => $customerOrders) {
    echo $phone;
    echo "<br>";
    foreach ($customerOrders as $customerOrder) {
        echo date('d.m.y', $customerOrder->created_at)."&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    echo "<hr>";
}
