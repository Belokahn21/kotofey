<?php


namespace app\modules\delivery\models\service\delivery\api;


use app\modules\delivery\models\service\delivery\api\DeliveryApi;
use app\modules\delivery\models\service\delivery\tariffs\CdekTariffData;
use app\modules\delivery\models\service\delivery\tariffs\RuPostTariffData;
use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Money;
use yii\helpers\Json;

class CdekApi implements DeliveryApi
{
    private $_LOGIN = 'info@kotofey.store';
    private $_PASSWORD = '123qweR%';
    private $_TOKEN = '0t_jz_hNllKIgH5Z_Rc7z1cHI2RiMmqx';
    private $_URL = 'https://api.edu.cdek.ru';

    private $_AUTH_HEADERS;

    const ACTION_TARIF = "/v2/calculator/tarifflist";

    public function __construct()
    {
        $this->_AUTH_HEADERS = [
            "Authorization: AccessToken " . $this->_TOKEN,
            "X-User-Authorization: Basic " . rand(),
            'Content-Type: application/json;charset=UTF-8',
        ];
    }

    public function getNormalAddress($address)
    {
        // TODO: Implement getNormalAddress() method.
    }

    public function getPriceInfo(TariffDataInterface $tariff_data)
    {
        /* @var $tariff_data CdekTariffData */
        $result = $this->sendRequest($this->_URL . self::ACTION_TARIF, [
            "type" => 1,
            "date" => date('Y-m-dTh:i:s+0700'),
            "currency" => 1,
            "lang" => "rus",
            "from_location" => [
                'postal_code' => $tariff_data->from_location
            ],
            "to_location" => [
                'postal_code' => $tariff_data->to_location
            ],
            "packages" => [
                [
                    "height" => 10,
                    "length" => 10,
                    "weight" => 4000,
                    "width" => 10
                ]
            ],
        ], $this->_AUTH_HEADERS);

        if (!array_key_exists('total-rate', $result)) {
            throw new \Exception($result['desc']);
        }

        Debug::p($result);
        exit();

        return [
            'total' => Money::convertCopToRub($result['total-rate']),
            'time' => [
                'max-days' => $result['delivery-time']['max-days']
            ]
        ];
    }

    public function sendRequest(string $url, array $data = [], array $headers = [])
    {

        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        return Json::decode($response);
    }
}