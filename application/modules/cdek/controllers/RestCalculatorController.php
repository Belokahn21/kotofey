<?php

namespace app\modules\cdek\controllers;

use app\modules\site\models\tools\Debug;
use app\modules\cdek\models\helpers\CdekDeliveryHelper;
use yii\db\Exception;
use yii\helpers\Json;
use yii\rest\Controller;

class RestCalculatorController extends Controller
{
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
        $data = \Yii::$app->request->get();
        $url = 'http://api.cdek.ru/calculator/calculate_tarifflist.php';
        $cityId = $data['get_city_id'];
        $postcode = $data['get_postcode'];
        $size = CdekDeliveryHelper::getBoxSize($data['size']);


        if (empty($cityId) or empty($postcode)) {
            throw new \yii\base\Exception('Empty city id or postcode');
        }


        $params = [
            'authLogin' => 'Z4Y3nJnT1HlpPHyXFiqrYr4c4jk9EJuo',
            'secure' => 'M1UffVhH2XmnMa63qR2UXNGOoSnJ5t4y',
            'dateExecute' => date('Y-m-d'),

            'version' => '1.0',
            'senderCityId' => 274,    //Барнаул
            'senderCityPostCode' => 656961,    //Барнаул
            'receiverCityId' => $cityId,    //Бийск
            'receiverCityPostCode' => $postcode,    //Бийск
            'tariffId' => 139,
            'goods' => [
                [
                    'weight' => $size['weight'],
                    'length' => $size['length'],
                    'width' => $size['width'],
                    'height' => $size['height'],
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

        return $result;
    }
}
