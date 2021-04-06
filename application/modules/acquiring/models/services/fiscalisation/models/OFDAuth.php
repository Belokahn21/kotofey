<?php


namespace app\modules\acquiring\models\services\fiscalisation\models;


use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class OFDAuth
{
    const URL = 'https://ferma.ofd.ru/api/Authorization/CreateAuthToken';
    const DEMO_URL = 'https://ferma-test.ofd.ru/api/Authorization/CreateAuthToken';

    public function __construct($login, $password)
    {
        $response = $this->send(self::DEMO_URL, [
            'Login' => $login,
            'Password' => $password
        ]);


        $data = Json::decode($response);



        return [
            'token' => $data['Data']['AuthToken'],
        ];
    }


    public function send($url, $data = [], $headers = [])
    {
        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);


            $finish_headers = [
                'Content-Type: application/json;charset=utf-8 ',
            ];
            if ($headers) $finish_headers = array_merge($finish_headers, $headers);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $finish_headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        return $response;
    }

    public function sendRequest(string $url, array $data = [], array $headers = [])
    {
        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        return Json::decode($response);
    }
}