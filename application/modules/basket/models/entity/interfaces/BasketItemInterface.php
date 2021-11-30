<?php

namespace app\modules\basket\models\entity\interfaces;

interface BasketItemInterface
{
    public function setId($id);
    public function getId();

    public function setName(string $name);
    public function getName();

    public function setCount(int $count);
    public function getCount();

    public function setPrice(int $price);
    public function getPrice();

    public function setWeight(float $price);
    public function getWeight();
}