<?php

if ($curl = curl_init()) {


    $params = [
        11
    ];


    \app\modules\site\models\tools\Debug::p($params);


    curl_setopt($curl, CURLOPT_URL, 'http://local.kotofey.store/api/delivery/tariffs/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    $out = curl_exec($curl);
    curl_close($curl);


    echo $out;
}