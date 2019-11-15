<?php


use app\models\tool\vk\Market;
use app\models\tool\vk\MarketProduct;

$product = new MarketProduct();
$product->name = 'Товар для ВК';
$product->description = 'Описание товара';
$product->price = 800;


$market = new Market();
$response = $market->add($product);

echo "Товар был добавлен";
