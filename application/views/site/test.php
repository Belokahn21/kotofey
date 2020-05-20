<?php

use app\models\tool\parser\ParseProvider;
use yii\helpers\Json;

$url = 'http://www.sat-altai.ru/catalog/?c=shop&a=item&number=000041457&category=';


//$parser = new ParseProvider($url);
//$parser->contract();
//$response = Json::encode($parser->getInfo());
//
//echo "<pre>";
//print_r($url);
//echo "</pre>";


if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://mysite.ru/receiver.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "a=4&b=7");
    $out = curl_exec($curl);
    echo $out;
    curl_close($curl);
}