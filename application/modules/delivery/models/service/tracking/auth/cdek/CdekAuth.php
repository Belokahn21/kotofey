<?php

namespace app\modules\delivery\models\service\tracking\auth\cdek;

class CdekAuth
{
    private $_auth_api;

    public function getAuthData()
    {
        $login = null;
        $password = null;
        $module = \Yii::$app->getModule('delivery');

        if (YII_ENV == 'dev') {
            $login = $module->cdek_client_id_dev;
            $password = $module->cdek_client_secret_dev;
        } else {
            $login = $module->cdek_client_id_prod;
            $password = $module->cdek_client_secret_prod;
        }

        if ($login === null || empty($login)) throw new \Exception('Cdek client_id не указан для авторизации.');
        if ($password === null || empty($password)) throw new \Exception('Cdek client_secret не указан для авторизации.');


        switch (YII_ENV) {
            case "dev":
                $this->_auth_api = new CdekAuthTest($login, $password);
                break;
            case "prod":
                $this->_auth_api = new CdekAuthProd($login, $password);
                break;
            default:
                throw new \Exception('YII_ENV не определён. Невозможно авторизоваться.');
        }

        return $this->_auth_api->auth();
    }
}