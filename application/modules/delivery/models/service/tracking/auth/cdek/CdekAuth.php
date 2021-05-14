<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;


class CdekAuth
{
    private $_auth_api;

    public function __construct()
    {

        $module = \Yii::$app->getModule('delivery');

        $login = $module->cdek_login;
        $password = $module->cdek_password;

        switch (YII_ENV) {
            case "dev":
                return $this->_auth_api = new CdekAuthTest($login, $password);
                break;
            case "prod":
                return $this->_auth_api = new CdekAuthProd($login, $password);
                break;
            default:
                throw new \Exception('YII_ENV не определён. Невозможно авторизоваться.');
                break;
        }
    }
}