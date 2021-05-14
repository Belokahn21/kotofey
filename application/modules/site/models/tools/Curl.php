<?php

namespace app\modules\site\models\tools;


class Curl
{
    public function post(string $url, array $data = [], array $headers = [])
    {
        $out = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            $out = curl_exec($curl);
            curl_close($curl);
        }

        return $out;
    }

    public function get(string $url, array $data = [], array $headers = [])
    {
        $response = false;
        if ($curl = curl_init($url . '?' . http_build_query($data))) {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }
        return $response;
    }
}