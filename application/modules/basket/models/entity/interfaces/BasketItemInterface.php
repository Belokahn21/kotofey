<?php

namespace app\modules\basket\models\entity\interfaces;

use app\modules\catalog\models\entity\Product;

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

    public function setProductId(int $product_id);

    public function getProductId();

    /**
     * @return Product
     */
    public function getProduct();
}