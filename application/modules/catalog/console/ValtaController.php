<?php


namespace app\modules\catalog\console;


use yii\console\Controller;

class ValtaController extends Controller
{
    public function actionUpdate()
    {
        $login = 'VasinKV_NSK';
        $password = 'aP85jU21g0';
        $url = 'ws.valta.ru:8888/uppms/ws/exchange.1cws?wsdl';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
//        echo($result);


        curl_setopt($ch, CURLOPT_URL, 'ws.valta.ru:8888/uppms/ws/exchange.1cws#Exchange:GetGoodList');
        $result = curl_exec($ch);
        echo($result);


        curl_close($ch);

    }
}