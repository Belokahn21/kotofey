<?php


namespace app\modules\delivery\models\service\delivery;


class RussianPostApi implements DeliveryApi
{
    private $_TOKEN = 'F_Z0iEUngYDe_tOpM2oHlToP_rkMCS9N';
    private $_AUTH_KEY = 'OTk2NzAyNjYzNzoxMjNxd2VSJQ==';
    private $_URL = 'otpravka-api.pochta.ru';

    public function getNormalAddress($address)
    {
        // TODO: Implement getNormalAddress() method.
    }

    public function getPriceInfo($address)
    {
        return $this->sendRequest($this->_URL, [
            "index-from" => "101000",
            "index-to" => "644015",
            "mail-category" => "ORDINARY",
            "mail-type" => "POSTAL_PARCEL",
            "mass" => '1000',
            "dimension" => [
                "height" => 2,
                "length" => 5,
                "width" => 197
            ],
            "fragile" => "true"
        ], [
            'Content-Type: application/json;charset=UTF-8',
            "Authorization: AccessToken " . $this->_TOKEN,
        ]);
    }

    public function sendRequest(string $url, array $data = [], array $headers = [])
    {
        $result = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

            $result = curl_exec($curl);
            curl_close($curl);
        }

        var_dump($result);

        return $result;
    }
}