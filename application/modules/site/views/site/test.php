<?php


$actions[8] = 'два пауча';
$actions[9] = 'скидка 25%';
$actions[7] = '5 паучей';
$actions[11] = 'скидка 5%';



$basket = \app\modules\basket\models\entity\Basket::findAll();
foreach ($basket as $item) {
    echo $item->product_id . ' = ' . $item->name;
    echo '<br>';
    echo $actions[$item->product_id];
    echo '<hr>';
}


