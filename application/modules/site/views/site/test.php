<?php


try {
    $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        ),
    );

    $context = stream_context_create($opts);

    $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE,

        'login' => 'VasinKV_NSK',
        'password' => 'aP85jU21g0',
    );


    $soap = new  SoapClient('ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl', $soapClientOptions);

    \app\modules\site\models\tools\Debug::p($soap->__call("GetGoodList", [
        'ClientId' => '3d49908e-4ee1-11ea-8156-005056bf23ce',
    ]));

//    print($soap->__call(
//        /* Имя SOAP-метода */
//            "GetGoodList",
//            /* Параметры */
////            array(
////                new SoapParam(
////                /* Значение параметра */
////                    "ibm",
////                    /* Имя параметра */
////                    "symbol"
////                )),
//            /* Опции */
//            array(
//                /* Пространство имен SOAP-метода */
//                "uri" => "urn:xmethods-delayed-quotes",
//                /* HTTP-заголовок SOAPAction  для SOAP-метода */
//                "soapaction" => "urn:xmethods-delayed-quotes#getQuote"
//            )). "\n");


} catch (SoapFault $e) {
}


exit();
if ($curl = curl_init()) {
    curl_setopt($curl, CURLOPT_URL, 'ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl');
//    curl_setopt($curl, CURLOPT_URL, 'ws.valta.ru:8888/uppms/ws/exchange.1cws?GetGoodList');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


    $headers = array(
        'Authorization: Basic ' . base64_encode("VasinKV_NSK:aP85jU21g0"),
        'Content-Length: 0'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curl, CURLOPT_POST, true);
    $out = curl_exec($curl);

    print_r($out);

    echo iconv("UTF-8", "ISO-8859-1", $out);


    curl_close($curl);
}
?>