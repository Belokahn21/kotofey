<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;

use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\CurlDataFormat;
use yii\helpers\Json;

class AbstractCdekAuthApi implements CdekAuthApiInterface
{
    protected $_url;
    protected $_login;
    protected $_password;

    public function __construct(string $login, string $password)
    {
        $this->_login = $login;
        $this->_password = $password;
    }

    public function auth()
    {
        $curl = new Curl();
        $response = $curl->post($this->_url,
            CurlDataFormat::asFormData([
                'grant_type' => 'client_credentials',
                'client_id' => $this->_login,
                'client_secret' => $this->_password,
            ]),
            [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        );

        return Json::decode($response, false);
    }

}