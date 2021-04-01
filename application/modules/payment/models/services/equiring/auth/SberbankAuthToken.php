<?php


namespace app\modules\payment\models\services\equiring\auth;


use app\modules\payment\models\services\equiring\auth\SberbankAuth;

class SberbankAuthToken implements SberbankAuth
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getAuthParams(&$params)
    {
        $params['token'] = $this->token;
    }
}