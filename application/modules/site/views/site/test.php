<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$url = 'http://ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl';
$login = 'VasinKV_NSK';
$password = 'aP85jU21g0';
$id = "3d49908e-4ee1-11ea-8156-005056bf23ce";

$client = new SoapClient($url, [
    'cache_wsdl' => WSDL_CACHE_NONE,
    'trace' => true,
//    'exceptions' => 0,
    'login' => $login,
    'password' => $password,
]);


\app\modules\site\models\tools\Debug::p($client->__getFunctions());

$params = new stdClass();
$params->ClientID = $id;


//$response = $client->__soapCall('GetGoodList', $params);
$response = $client->GetGoodList($params);

\app\modules\site\models\tools\Debug::p($response);
?>