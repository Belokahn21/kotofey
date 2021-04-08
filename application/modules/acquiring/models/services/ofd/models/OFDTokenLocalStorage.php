<?php


namespace app\modules\acquiring\models\services\ofd\models;


class OFDTokenLocalStorage
{
    const SESSION_KEY_TOKEN = 'ofd_token';
    const SESSION_KEY_EXP = 'ofd_token_exp';

    public function save($value, $expiration)
    {
        \Yii::$app->session->open();
        \Yii::$app->session->set(self::SESSION_KEY_TOKEN, $value);
        \Yii::$app->session->set(self::SESSION_KEY_EXP, $expiration);
    }

    public function loadToken()
    {
        \Yii::$app->session->open();
        return \Yii::$app->session->get(self::SESSION_KEY_TOKEN);
    }

    public function loadTokenExp()
    {
        \Yii::$app->session->open();
        return \Yii::$app->session->get(self::SESSION_KEY_EXP);
    }

    public function convertDateTo($ofd_exp_date)
    {

    }
}