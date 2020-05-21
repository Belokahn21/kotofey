<?php

if ($curl = curl_init()) {

    $url = 'https://shop.purina.ru/catalogsearch/result/?q=12382848';

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $out = curl_exec($curl);
    curl_close($curl);


    var_dump($out);
}