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

