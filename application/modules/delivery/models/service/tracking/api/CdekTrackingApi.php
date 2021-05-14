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
    private $_url;

    public function __construct()
    {
        $this->auth = (new CdekAuth())->getAuthData();

        switch (YII_ENV) {
            case 'dev':
                $this->_url = 'https://api.edu.cdek.ru/v2/';
                break;
            case 'prod':
                $this->_url = 'https://api.cdek.ru/v2/';
                break;
        }
    }

    public function getOrderInfo(string $track_id)
    {
        $this->getRequest("orders?cdek_number=$track_id");
    }

    public function postRequest(string $url, array $params = [], array $headers = [])
    {
        if ($this->auth) {
            $headers[] = 'Authorisation: Bearer ' . $this->auth->access_token;
        }

        $curl = new Curl();
        $response = $curl->post($this->_url . $url, $params, $headers);

        Debug::p($response);
    }

    public function getRequest(string $url, array $params = [], array $headers = [])
    {

        if ($this->auth) {
            $headers[] = 'Authorisation: Bearer ' . $this->auth->access_token;
        }

        $curl = new Curl();
        $response = $curl->get($this->_url . $url, $params, $headers);

        Debug::p($response);
    }


}