<?php

use app\models\tool\parser\ParseProvider;
use yii\helpers\Json;

$url = 'http://www.sat-altai.ru/catalog/?c=shop&a=item&number=000041457&category=';


$parser = new ParseProvider($url);
$parser->contract();
$response = Json::encode($parser->getInfo());

print_r($url);