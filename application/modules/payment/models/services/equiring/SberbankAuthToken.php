<?php


namespace app\modules\payment\models\services\equiring;


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