<?php
use app\modules\catalog\models\helpers\ProductPropertiesHelper;

\app\models\tool\Debug::p(ProductPropertiesHelper::getAllProperties(1211));




//$url = 'http://api.cdek.ru/calculator/calculate_tarifflist.php';
//
//$params = [
//    'authLogin'=>'Z4Y3nJnT1HlpPHyXFiqrYr4c4jk9EJuo',
//    'secure'=>'M1UffVhH2XmnMa63qR2UXNGOoSnJ5t4y',
//    'dateExecute'=>'2020-10-19',
//
//    'version' => '1.0',
//    'senderCityId' => 274,    //Барнаул
//    'senderCityPostCode' => 656961,    //Барнаул
//    'receiverCityId' => 275,    //Бийск
//    'receiverCityPostCode' => 659312,    //Бийск
//    'tariffId' => 139,
////    'tariffId' => 62,
//    'goods' => [
//        [
//            'weight' => 5,
//            'length' => 11,
//            'width' => 59,
//            'height' => 39,
//        ]
//    ],
//];
//
//$data_string = json_encode($params, JSON_UNESCAPED_UNICODE);
//$curl = curl_init('http://api.cdek.ru/calculator/calculate_tarifflist.php');
//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
//curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
//// Принимаем в виде массива. (false - в виде объекта)
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//        'Content-Type: application/json',
//        'Content-Length: ' . strlen($data_string))
//);
//$result = curl_exec($curl);
//curl_close($curl);
//\app\models\tool\Debug::p(\yii\helpers\Json::decode($result));
//$page = new \app\models\tool\parser\ParseProvider('http://www.sat-altai.ru/catalog/?c=shop&a=item&number=000018664&category=');
//$page->contract();
//\app\models\tool\Debug::p($page->getInfo());

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