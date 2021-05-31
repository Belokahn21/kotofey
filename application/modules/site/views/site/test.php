<?php
ini_set('default_socket_timeout', 10000);
$wsdlurl = 'ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl';
error_reporting(E_ALL);
ini_set("soap.wsdl_cache_enabled", "0");
$wsdl_url = $wsdlurl;
$login = 'VasinKV_NSK';
$password = 'aP85jU21g0';
$service_location = 'http://dir/DataService.asmx';
$service_uri = 'http://uri.org/';

try {
    //не-WSDL

    $options = array('login' => $login,
        'password' => $password,
        'location' => $service_location,
        'uri' => $service_uri,
        'authentication' => 'SOAP_AUTHENTICATION_DIGEST',
        'trace' => true,
        'exceptions' => true,
        'cache_wsdl' => 'WSDL_CACHE_NONE',
        'soap_version' => 'SOAP_1_1');

    try {
        $client = new SoapClient($wsdl_url, $options);
    } catch (Exception $e) {
        print"Ошибка создания объекта SOAP:<br>" . $e->getMessage() . "<br>" . $e->getTraceAsString();
    }

    $params = array('ClientId' => 52, 'Date' => new DateTime());

    try {
        $response = $client->GetGoodList($params);
    } catch (Exception $e) {
        print"Ошибка вызова функции GetGoodList:<br>" . $e->getMessage() . "<br>" . $e->getTraceAsString();
    }

} catch (Exception $e) {
    print "Ошибка работы с SOAP:<br>" . $e->getMessage() . "<br>" . $e->getTraceAsString();
}
?>

?>