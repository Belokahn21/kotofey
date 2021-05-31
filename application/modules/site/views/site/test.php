<?php
$order = \app\modules\order\models\entity\Order::findOne(621);

$tracking = new \app\modules\order\models\service\TrackingService($order);
\app\modules\site\models\tools\Debug::p($tracking->getOrderInfo());

?>

<?
// проверяем наличие класса SoapClient
//if (class_exists('SoapClient')){
//
//    // отключаем кэширование
//    ini_set("soap.wsdl_cache_enabled", "0" );
//
//    // подключаемся к серверу
//    $client = new SoapClient(
//        "https://tracking.russianpost.ru/rtm34?wsdl",
//        array(
//            "soap_Login", // логин
//            "soap_password" // пароль
//        )
//    );
//
//    // обращаемся к функции, передаем параметры
//    $result = $client->GetOrderInfo( array('OrderCode' => '20001827') );
//
//    if ($result->return){
//
//        // обращаемся к данным в виде объектов
//        echo
//            'Product: ' . $result->return->cmp->ProdName . '<br>' .
//            'Amount'    . $result->return->cmp->Amount .
//            'Price'     . $result->return->cmp->Price;
//
//    } else echo "Не удалось получить данные!";
//} else echo "Включите поддержку SOAP в PHP!";
?>

<?php
//$wsdlurl = 'https://tracking.russianpost.ru/rtm34?wsdl';
//$client2 = '';
//
//$client2 = new SoapClient($wsdlurl, array('trace' => 1, 'soap_version' => SOAP_1_2));
//
//$params3 = array ('OperationHistoryRequest' => array ('Barcode' => '80096460841518', 'MessageType' => '0','Language' => 'RUS'),
//    'AuthorizationHeader' => array ('login'=>'KMhQooASlzAFLD','password'=>'BqT6Moh5ucj5'));
//
//$result = $client2->getOperationHistory(new SoapParam($params3,'OperationHistoryRequest'));
//
//\app\modules\site\models\tools\Debug::p($result);
//
//exit();
//
////foreach ($result->OperationHistoryData->historyRecord as $record) {
////    printf("<p>%s </br>  %s, %s</p>",
////        $record->OperationParameters->OperDate,
////        $record->AddressParameters->OperationAddress->Description,
////        $record->OperationParameters->OperAttr->Name);
////};
?>


<?php
$wsdlurl = 'https://tracking.russianpost.ru/rtm34?wsdl';
$client2 = '';
$barcode = "111111";
$login = "my_login";
$password = "my_password";
$request = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:oper="http://russianpost.org/operationhistory" xmlns:data="http://russianpost.org/operationhistory/data" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:data1="http://www.russianpost.org/RTM/DataExchangeESPP/Data">
   <soap:Header/>
   <soap:Body>
      <oper:PostalOrderEventsForMail>
         <!--Optional:-->
         <data:AuthorizationHeader soapenv:mustUnderstand="">
            <data:login>' . $login . '</data:login>
            <data:password>' . $password . '</data:password>
         </data:AuthorizationHeader>
         <!--Optional:-->
         <data1:PostalOrderEventsForMailInput Barcode="' . $barcode . '" Language=""/>
      </oper:PostalOrderEventsForMail>
   </soap:Body>
</soap:Envelope>';

$client = new SoapClient($wsdlurl, array('trace' => 1, 'soap_version' => SOAP_1_2));

echo '<textarea>' . $client->__doRequest($request, "https://tracking.russianpost.ru/rtm34", "PostalOrderEventsForMail", SOAP_1_2) . '</textarea>';
?>


<?php
$request = '<?xml version="1.0" encoding="UTF-8"?>
                <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:oper="http://russianpost.org/operationhistory" xmlns:data="http://russianpost.org/operationhistory/data" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Header/>
                <soap:Body>
                   <oper:getOperationHistory>
                      <data:OperationHistoryRequest>
                         <data:Barcode>?</data:Barcode>  
                         <data:MessageType>0</data:MessageType>
                         <data:Language>RUS</data:Language>
                      </data:OperationHistoryRequest>
                      <data:AuthorizationHeader soapenv:mustUnderstand="1">
                         <data:login>mylogin</data:login>
                         <data:password>mypassword</data:password>
                      </data:AuthorizationHeader>
                   </oper:getOperationHistory>
                </soap:Body>
             </soap:Envelope>';

$client = new SoapClient("https://tracking.russianpost.ru/rtm34?wsdl", array('trace' => 1, 'soap_version' => SOAP_1_2));

echo '<textarea>' . $client->__doRequest($request, "https://tracking.russianpost.ru/rtm34", "getOperationHistory", SOAP_1_2) . '</textarea>';
?>


