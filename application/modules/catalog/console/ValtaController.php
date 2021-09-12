<?php


namespace app\modules\catalog\console;

use SoapClient;
use stdClass;
use yii\console\Controller;

class ValtaController extends Controller
{
    public function saveExchange()
    {
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

//$params = new stdClass();
//$params->ClientID = $id;
        $params = new stdClass();
        $params->ClientID = $id;
        $params->StockIdList = null;


//$response = $client->__soapCall('GetGoodList', $params);
//$response = $client->GetGoodList($params);
        $response = $client->GetGoodStock($params);
        $response = \yii\helpers\ArrayHelper::toArray($response);
        \app\modules\site\models\tools\Debug::p($response);

        exit();

        if ($response) {
            foreach ($response['return']['Result'] as $valta_product) {
                \app\modules\site\models\tools\Debug::p($valta_product);
//        \app\modules\site\models\tools\Debug::p($valta_product['Name']);

                exit();
            }
        }
    }

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