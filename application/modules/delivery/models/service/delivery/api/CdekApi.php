<?php


namespace app\modules\delivery\models\service\delivery\api;


use app\modules\delivery\models\service\delivery\api\DeliveryApi;
use app\modules\delivery\models\service\delivery\tariffs\CdekTariffData;
use app\modules\delivery\models\service\delivery\tariffs\RuPostTariffData;
use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;
use app\modules\delivery\models\service\tracking\api\CdekTrackingApi;
use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuth;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Money;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class CdekApi implements DeliveryApi
{
    private $_URL;
    private $auth;
    private $_AUTH_HEADERS;

    const ACTION_TARIF = "/v2/calculator/tarifflist";

    public function __construct()
    {
        $this->auth = (new CdekAuth())->getAuthData();

        switch (YII_ENV) {
            case "dev":
                $this->_URL = 'https://api.edu.cdek.ru';
                break;
            case "prod":
                $this->_URL = 'https://api.cdek.ru';
                break;
        }

        if ($this->auth) {
            $this->_AUTH_HEADERS = [
                "Authorization: Bearer {$this->auth->access_token}",
            ];
        }

    }

    public function getNormalAddress($address)
    {
        // TODO: Implement getNormalAddress() method.
    }

    public function getPriceInfo(TariffDataInterface $tariff_data)
    {
        $api = new  CdekTrackingApi();
        $responsee = $api->calculate();

        Debug::p($responsee);
        exit();
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