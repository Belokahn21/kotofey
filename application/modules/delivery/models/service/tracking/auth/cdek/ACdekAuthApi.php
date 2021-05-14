<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;


use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\Debug;

class ACdekAuthApi implements CdekAuthApiInterface
{
    protected $_url;

    public function __construct(string $login, string $password)
    {
        $curl = new Curl();
        $response = $curl->post($this->_url, [
            'grant_type' => '',
            'client_id' => '',
            'client_secret' => '',
        ]);

        Debug::p($response);
    }
}