<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;


class CdekAuth
{
    private $_auth_api;

    public function getAuthData()
    {
        $module = \Yii::$app->getModule('delivery');
//        $login = $module->cdek_login;
//        $password = $module->cdek_password;

        if (YII_ENV == 'dev') {
            $login = 'EMscd6r9JnFiQ3bLoyjJY6eM78JrJceI';
            $password = 'PjLZkKBHEiLK3YsjtNrt3TGNG0ahs3kG';
        } else {
            $login = 'zwIwSlOu6gzahO9Wfrt7JZ0nuxim2btq';
            $password = 'SFrBOZ3xzjjyqi4zfYE0SiaH8yn2bHeV';
        }


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