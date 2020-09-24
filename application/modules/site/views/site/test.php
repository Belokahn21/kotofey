<?php
//2273р. 27коп.
$parser = new \app\models\tool\parser\ParseProvider('http://www.sat-altai.ru/catalog/?c=shop&a=item&number=000016871&category=00000226');
$parser->contract();
\app\models\tool\Debug::p($parser->getInfo());

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