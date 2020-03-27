<?php
$data = \Yii::$app->request->post();
$code = '000059471';
$code = '000072586';


$opts = array(
	'http'=>array(
		'method'=>"GET",
		'header'=>"Accept-language: en\r\n" .
			"Cookie: beget=begetok\r\n"
	)
);

$context = stream_context_create($opts);

$domain1 = "http://www.sat-altai.ru/catalog/?c=shop&a=item&number={$code}&category=";


// Открываем файл с помощью установленных выше HTTP-заголовков
$file = file_get_contents($domain1, false, $context);

var_dump(stristr($file,'<span class=sklad>В наличии</span>')!==false);
