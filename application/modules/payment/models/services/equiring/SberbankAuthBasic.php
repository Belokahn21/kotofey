<?php


namespace app\modules\payment\models\services\equiring;


class SberbankAuthBasic implements SberbankAuth
{
    public $login;
    public $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getAuthParams(&$params)
    {
        $params['userName'] = $this->login;
        $params['password'] = $this->password;
    }
}