<?php


namespace app\modules\acquiring\models\services\fiscalisation\models;


use yii\helpers\Json;

class OFDAuth
{
    const URL = '';

    public function __construct($login, $password)
    {
        $response = $this->send(self::URL, [
            'login' => $login,
            'password' => $password
        ]);


        return [
            'token' => $response['token'],
        ];
    }


    public function send($url, $data = [])
    {
        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        return $response;
    }
}