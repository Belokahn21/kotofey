<?php

$page = new \app\models\tool\parser\ParseProvider('http://www.sat-altai.ru/catalog/?c=shop&a=item&number=000018664&category=');
$page->contract();
\app\models\tool\Debug::p($page->getInfo());

?>

<?php
/*
use app\modules\order\models\entity\Order;
$orders = array();
$phoneCustomer = Order::find()->select('phone')->all();

foreach ($phoneCustomer as $phone) {
    $orders[$phone->phone] = Order::find()->orderBy(['created_at' => SORT_ASC])->where(['phone' => $phone->phone])->all();
}


foreach ($orders as $phone => $customerOrders) {
    echo $phone;
    echo "<br>";

    $oldDate = null;
    $currentDate = null;
    $countOrders = 0;
    $countDays = 0;

    foreach ($customerOrders as $customerOrder) {

        $currentDate = new DateTime();
        $currentDate->setTimestamp($customerOrder->created_at);

        if ($oldDate instanceof DateTime) {
            $diff = $oldDate->diff($currentDate);

            $countDays += (int)$diff->d;

            echo $currentDate->format('d.m.Y') . '(' . $diff->d . ')' . "&nbsp;&nbsp;&nbsp;&nbsp;";
        } else {
            echo $currentDate->format('d.m.Y') . "&nbsp;&nbsp;&nbsp;&nbsp;";
        }

        $countOrders++;
        $oldDate = $currentDate;
    }

    echo "Среднее кол-во дней между заказами: " . floor($countDays / $countOrders);
    echo "<hr>";
}
*/ ?>