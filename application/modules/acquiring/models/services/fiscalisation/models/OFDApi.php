<?php

namespace app\modules\acquiring\models\services\fiscalisation\models;


class OFDApi
{
    public function sendCheck()
    {

    }

    public function send()
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, 'http://mysite.ru/receiver.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "a=4&b=7");
            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        }
    }
}