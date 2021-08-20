<?php


namespace app\modules\delivery\models\service\delivery\api;

use app\modules\delivery\models\service\delivery\response\ResponseNormalizer;
use app\modules\delivery\models\service\delivery\tariffs\RuPostTariffData;
use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class RussianPostApi implements DeliveryApiOld
{
    private $_LOGIN = 'info@kotofey.store';
    private $_PASSWORD = '123qweR%';
    private $_TOKEN = '0t_jz_hNllKIgH5Z_Rc7z1cHI2RiMmqx';
    private $_URL = 'https://otpravka-api.pochta.ru';
    private $_AUTH_HEADERS;

    const ACTION_TARIF = "/1.0/tariff";
    const ACTION_NORMAL = "/1.0/clean/address";
    const ACTION_NORMAL_PHONE = "/1.0/clean/phone";

    public function __construct()
    {
        $this->_AUTH_HEADERS = [
            "Authorization: AccessToken " . $this->_TOKEN,
            "X-User-Authorization: Basic " . $this->getAuthKey($this->_LOGIN, $this->_PASSWORD),
            'Content-Type: application/json;charset=UTF-8',
        ];
    }

    public function getNormalAddress($address)
    {
        $result = $this->sendRequest($this->_URL . self::ACTION_NORMAL, [
            [
                "id" => "adr 1",
                "original-address" => $address
            ]
        ], $this->_AUTH_HEADERS);

        return $result;
    }

    public function getNormalPhone($phone)
    {
        $result = $this->sendRequest($this->_URL . self::ACTION_NORMAL_PHONE, [
            [
                "id" => "tel2",
                "original-phone" => $phone
            ]
        ], $this->_AUTH_HEADERS);

        return $result;
    }

    public function getPriceInfo(TariffDataInterface $tariff_data)
    {
        /* @var $tariff_data RuPostTariffData */
        $response = $this->sendRequest($this->_URL . self::ACTION_TARIF, [
            "index-from" => $tariff_data->index_from,
            "index-to" => $tariff_data->index_to,
            "mail-category" => $tariff_data->mail_category,
            "mail-type" => $tariff_data->mail_type,
            "mass" => $tariff_data->mass,
            "inventory" => false,
            "fragile" => false,
            "with-order-of-notice" => false,
            "with-simple-notice" => false,
        ], $this->_AUTH_HEADERS);

        if (!array_key_exists('total-rate', $response)) {
            throw new \Exception($response['desc']);
        }

        $normalizer = new ResponseNormalizer();
        return $normalizer->normalize(ResponseNormalizer::SERVICE_RU_POST, $response);
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

    /**
     * @return mixed
     */
    public function getAuthKey($login, $password)
    {
        return base64_encode("$login:$password");
    }
}