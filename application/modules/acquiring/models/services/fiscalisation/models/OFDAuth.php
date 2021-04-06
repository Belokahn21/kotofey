<?php


namespace app\modules\acquiring\models\services\fiscalisation\models;


use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class OFDAuth
{
    const URL = 'https://ferma.ofd.ru/api/Authorization/CreateAuthToken';

    public function __construct($login, $password)
    {
        $response = $this->send(self::URL, [
            'Login' => $login,
            'Password' => $password
        ]);


        $data = Json::decode($response);

        Debug::p($data);
        exit();


        return [
            'token' => $data['Data']['AuthToken'],
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