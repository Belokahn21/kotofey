<?php

namespace app\modules\acquiring\models\services\fiscalisation\models;


class OFDApi
{
    const URL = 'https://ferma.ofd.ru/api/kkt/cloud/';

    const ACTION_CREATE_CHECK = 'receipt';

    public function sendCheck()
    {
        $params = [];

        $this->send(self::ACTION_CREATE_CHECK, $params);
    }

    public function send($action, $data = [], $headers = [])
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, self::URL . $action);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "a=4&b=7");
            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        }
    }
}