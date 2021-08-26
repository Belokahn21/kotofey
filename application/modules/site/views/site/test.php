<?php

$url = 'http://ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl';
$login = 'VasinKV_NSK';
$password = 'aP85jU21g0';
$id = '3d49908e-4ee1-11ea-8156-005056bf23ce';

$client = new SoapClient($url, [
    'cache_wsdl' => WSDL_CACHE_NONE,
    'trace' => true,
//    'exceptions' => 0,
    'login' => $login,
    'password' => $password,
]);


\app\modules\site\models\tools\Debug::p($client->__getFunctions());

//$params = new stdClass();
//$params->ClientId = $id;
$params = ['ClientId' => $id];


//$myClass->token = new \stdClass;
////$myClass->token->user = $username;
////$myClass->token->password = $password;
//
//$myClass->projectId = 123;
//$myClass->start = 0;
//$myClass->count = 0;

$response = $client->__soapCall('GetGoodList', $params);
//$response = $client->GetGoodList($params);

\app\modules\site\models\tools\Debug::p($response);
?>