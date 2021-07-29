<?php

namespace app\modules\delivery\models\service\tracking\api;

use app\modules\delivery\models\service\delivery\response\ResponseNormalizer;
use app\modules\delivery\models\service\delivery\tariffs\CdekTariffData;
use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;
use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuth;
use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuthApiInterface;
use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\CurlDataFormat;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

/**
 * @property CdekAuthApiInterface $auth
 */
class CdekApi implements IDeliveryApi
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

        return Json::decode($response, true);
    }

    public function getRequest(string $url, array $params = [], array $headers = [])
    {

        if ($this->auth) {
            $headers[] = "Authorization: Bearer {$this->auth->access_token}";
        }

        $curl = new Curl();
        $response = $curl->get($this->_url . $url, $params, $headers);

        return Json::decode($response, true);
    }


    public function getNormalAddress($address)
    {
        // TODO: Implement getNormalAddress() method.
    }

    public function getPriceInfo(TariffDataInterface $tariff_data)
    {
        /* @var $tariff_data CdekTariffData */
        $params = [
            "type" => 1,
            "date" => date('Y-m-d\Th:i:s+0700'),
            "currency" => 1,
            "tariff_code" => 62,
            "lang" => "rus",
            "from_location" => [
                'postal_code' => $tariff_data->from_location
            ],
            "to_location" => [
                'postal_code' => $tariff_data->to_location
            ],
            "packages" => $tariff_data->packages,
        ];

//        Debug::p($params);
//        exit();

        $response = $this->postRequest('/calculator/tarifflist', CurlDataFormat::asJson($params), [
            'Content-Type:application/json'
        ]);


        $normalizer = new ResponseNormalizer();

        return $normalizer->normalize(ResponseNormalizer::SERVICE_CDEK, $response);
    }

    public function sendRequest(string $url, array $data = [], array $headers = [])
    {
        // TODO: Implement sendRequest() method.
    }
}