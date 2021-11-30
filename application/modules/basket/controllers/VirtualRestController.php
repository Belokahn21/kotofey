<?php

namespace app\modules\basket\controllers;

use app\modules\basket\models\entity\Basket;
use app\modules\basket\models\entity\VirtualBasketItem;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\catalog\models\repository\ProductRepository;
use yii\helpers\ArrayHelper;
use \yii\rest\Controller;

class VirtualRestController extends Controller
{
    public function actionCreate()
    {
        $data = \Yii::$app->request->post();

        $product_id = ArrayHelper::getValue($data, 'product_id', false);
        $weight = ArrayHelper::getValue($data, 'weight', false);
        $count = ArrayHelper::getValue($data, 'count', false);

        if (!$product_id || !$weight || !$count) throw new \Exception('Не все элементы переданы.');

        $weight = (float)$weight;

        if (!$product = ProductRepository::getOne($product_id)) throw new \Exception('Товара не сущестует.');

        $price_rate = floor($product->getPrice() / PropertiesHelper::getProductWeight($product->id));
        $price_rate = floatval($price_rate);

        $price = round($weight * $price_rate) * $count;
        $price = floatval($price);


        $element = new VirtualBasketItem();
        $element->setId($product_id . '_virtual');
        $element->setName($weight . 'кг. товара ' . $product->name);
        $element->setPrice($price);
        $element->setCount($price);
        $element->setWeight($weight);

        $basket = new Basket();
        $basket->add($element);
    }
}