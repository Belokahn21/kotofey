<?php

namespace app\modules\delivery\models\service\tracking\api;

use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuth;
use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuthApiInterface;
use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\Debug;

/**
 * @property CdekAuthApiInterface $auth
 */
class CdekTrackingApi implements TrackingApi
{
    public function __construct()
    {
        $this->auth = (new CdekAuth())->getAuthData();
    }

    public function getOrderInfo(string $track_id)
    {
        $this->postRequest("https://api.edu.cdek.ru/v2/orders?cdek_number=$track_id", [
            'Content-Type: application/json'
        ]);
    }

    public function postRequest(string $url, array $params, array $headers = [])
    {
        if ($this->auth) {
            $headers[] = 'Authorisation: Bearer ' . $this->auth->access_token;
        }

        $curl = new Curl();
        $response = $curl->get($url, $params, $headers);

        Debug::p($response);
    }

    public function getRequest($url, $params)
    {

    }
}