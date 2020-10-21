<?php

namespace app\modules\cdek\controllers;

use app\models\tool\Debug;
use yii\helpers\Json;
use yii\rest\Controller;

class RestCalculatorController extends Controller
{

//    public $modelClass = 'app\modules\todo\models\entity\TodoList';

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function actionGet()
    {
        $url = 'http://api.cdek.ru/calculator/calculate_tarifflist.php';

        $params = [
            'authLogin' => 'Z4Y3nJnT1HlpPHyXFiqrYr4c4jk9EJuo',
            'secure' => 'M1UffVhH2XmnMa63qR2UXNGOoSnJ5t4y',
//            'dateExecute'=>'2020-10-19',
            'dateExecute' => date('Y-m-d'),

            'version' => '1.0',
            'senderCityId' => 274,    //Барнаул
            'senderCityPostCode' => 656961,    //Барнаул
            'receiverCityId' => 275,    //Бийск
            'receiverCityPostCode' => 659312,    //Бийск
            'tariffId' => 139,
            'goods' => [
                [
                    'weight' => 5,
                    'length' => 11,
                    'width' => 59,
                    'height' => 39,
                ]
            ],
        ];


        $data_string = Json::encode($params);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($curl);
        curl_close($curl);

        return Json::encode($result);
    }
}
