<?php


(new \app\modules\order\models\service\NotifyService())->sendEmailClient(430);

//$url = 'http://www.sat-altai.ru/import_img/cache/max_000054264.jpg';
//
//$path      = parse_url($url, PHP_URL_PATH);       // get path from url
//$extension = pathinfo($path, PATHINFO_EXTENSION); // get ext from path
//$filename  = pathinfo($path, PATHINFO_FILENAME);  // get name from path

//\app\modules\site\models\tools\Debug::p($path);
//\app\modules\site\models\tools\Debug::p($extension);
//\app\modules\site\models\tools\Debug::p($filename);

//$actions[8] = 'два пауча';
//$actions[9] = 'скидка 25%';
//$actions[7] = '5 паучей';
//$actions[11] = 'скидка 5%';
//
//
//
//$basket = \app\modules\basket\models\entity\Basket::findAll();
//foreach ($basket as $item) {
//    echo $item->product_id . ' = ' . $item->name;
//    echo '<br>';
//    echo $actions[$item->product_id];
//    echo '<hr>';
//}


