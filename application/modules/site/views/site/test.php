<?php
ini_set('default_socket_timeout', 10000);
$wsdlurl = 'http://ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl';

$opts = array(
    'ssl' => array(
        'ciphers' => 'RC4-SHA',
        'verify_peer' => false,
        'verify_peer_name' => false
    )
);
// SOAP 1.2 client
$params = array(
    'encoding' => 'UTF-8',
    'verifypeer' => false,
    'verifyhost' => false,
    'soap_version' => SOAP_1_2,
    'trace' => 1,
    'exceptions' => 1,
    'connection_timeout' => 180,
    'stream_context' => stream_context_create($opts)
);

$client = new SoapClient($wsdlurl, $params);

//$params = array(
//    'OperationHistoryRequest' => array('Barcode' => '3d49908e-4ee1-11ea-8156-005056bf23ce', 'Date' => date('d.m.Y')),
//    'AuthorizationHeader' => array('login' => 'VasinKV_NSK', 'password' => 'aP85jU21g0')
//);
//
//$result = $client->GetGoodList(new SoapParam($params));

?>