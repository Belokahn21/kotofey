<?php

namespace app\modules\delivery\models\service\tracking\api;

use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuth;
use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuthApiInterface;
use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\CurlDataFormat;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

/**
 * @property CdekAuthApiInterface $auth
 */
class CdekTrackingApi implements TrackingApi
{
    private $_url;

    public function __construct()
    {
        $this->auth = (new CdekAuth())->getAuthData();

        switch (YII_ENV) {
            case 'dev':
                $this->_url = 'https://api.edu.cdek.ru/v2';
                break;
            case 'prod':
                $this->_url = 'https://api.cdek.ru/v2';
                break;
        }
    }

    public function calculate()
    {
        $params = [
            "type" => 1,
            "date" => "2020-11-03T11:49:32+0700",
//            "date" => date('Y-m-dTh:i:s+0700'),
            "currency" => 1,
            "tariff_code" => 62,
            "lang" => "rus",
            "from_location" => [
                'postal_code' => 656000
            ],
            "to_location" => [
                'postal_code' => 107078
            ],
            "packages" => [
                [
                    "height" => 10,
                    "length" => 10,
                    "weight" => 4000,
                    "width" => 10
                ]
            ],
        ];

        return $this->postRequest('/calculator/tarifflist', CurlDataFormat::asJson($params), [
            'Content-Type:application/json'
        ]);
    }

    public function getOrderInfo(string $track_id)
    {
        return $this->getRequest("orders?cdek_number=$track_id");
    }

    public function postRequest(string $url, $params = null, array $headers = [])
    {
        if ($this->auth) {
            $headers[] = "Authorization: Bearer {$this->auth->access_token}";
        }

        $curl = new Curl();
        $response = $curl->post($this->_url . $url, $params, $headers);

        return Json::decode($response, false);
    }

    public function getRequest(string $url, array $params = [], array $headers = [])
    {

        if ($this->auth) {
            $headers[] = "Authorization: Bearer {$this->auth->access_token}";
        }

        $curl = new Curl();
        $response = $curl->get($this->_url . $url, $params, $headers);

        return Json::decode($response, false);
    }


}