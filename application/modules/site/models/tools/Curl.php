<?php

namespace app\modules\site\models\tools;

class Curl
{
    public function post(string $url, $data = null, array $headers = [])
    {
        $out = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $out = curl_exec($curl);
            curl_close($curl);
        }

        return $out;
    }

    public function get(string $url, array $data = [], array $headers = [])
    {
        $response = false;

        if ($data) {
            $curl = curl_init($url . '?' . http_build_query($data));
        } else {
            $curl = curl_init($url);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}