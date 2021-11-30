<?php

namespace app\modules\basket\models\entity;

use app\modules\basket\models\entity\interfaces\BasketItemInterface;
use app\modules\catalog\models\repository\ProductRepository;

class OrmBasketItem implements BasketItemInterface
{
    private $id;
    private $name;
    private $weight;
    private $count;
    private $price;
    private $product_id;

    /**
     * @param mixed $weight
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCount(int $count)
    {
        $this->count = $count;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setProductId(int $product_id)
    {
        $this->product_id = $product_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getProduct()
    {
        return ProductRepository::getOne($this->product_id);
    }
}