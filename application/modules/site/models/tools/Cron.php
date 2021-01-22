<?php

namespace app\modules\site\models\tools;


class Cron
{
    public function post($url, $params)
    {
        $out = "";
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            $out = curl_exec($curl);
            curl_close($curl);
        }

        return $out;
    }

    public function get()
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, 'http://mysite.ru/receiver.php?a=5&b=10');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        }
    }
}