<?php


namespace app\modules\delivery\models\service\delivery;


use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class RussianPostApi implements DeliveryApi
{
    private $_LOGIN = 'info@kotofey.store';
    private $_PASSWORD = '123qweR%';
    private $_TOKEN = '0t_jz_hNllKIgH5Z_Rc7z1cHI2RiMmqx';
    private $_URL = 'https://otpravka-api.pochta.ru';

    const ACTION_TARIF = "/1.0/tariff";

    public function getNormalAddress($address)
    {
        // TODO: Implement getNormalAddress() method.
    }

    /**
     * @return mixed
     */
    public function getAuthKey($login, $password)
    {
        return base64_encode("$login:$password");
    }

    public function getPriceInfo($address)
    {
        return $this->sendRequest($this->_URL . self::ACTION_TARIF, [
            "index-from" => "656000",
            "index-to" => "644015",
            "mail-category" => "ORDINARY",
            "mail-type" => "ONLINE_PARCEL",
            "mass" => '1000',
            "dimension" => [
                "height" => 2,
                "length" => 5,
                "width" => 197
            ],
        ], [
            "Authorization: AccessToken " . $this->_TOKEN,
            "X-User-Authorization: Basic " . $this->getAuthKey($this->_LOGIN, $this->_PASSWORD),
            'Content-Type: application/json',
            'Accept: application/json;charset=UTF-8',
        ]);
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

        $result = Json::decode($response);

        if (!array_key_exists('total-rate', $result)) {
            throw new \Exception($result['error']);
        }

        return [
            'total' => $result['total-rate'],
            'time' => [
                'max-days' => $result['delivery-time']['max-days']
            ]
        ];
    }
}