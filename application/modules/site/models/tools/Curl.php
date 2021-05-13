<?php

namespace app\modules\site\models\tools;


class Curl
{
    public function post($url, $data, $headers = [])
    {
        $out = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            if ($headers) curl_setopt($curl, CURLOPT_HEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            $out = curl_exec($curl);
            curl_close($curl);
        }

        return $out;
    }

    public function get()
    {
    }
}