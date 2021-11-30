<?php

namespace app\modules\basket\models\entity;

use app\modules\basket\models\entity\interfaces\BasketItemInterface;

/**
 * @property int $id
 * @property int $count
 * @property int $price
 * @property string $name
 * @property float $weight
 */
class VirtualBasketItem implements BasketItemInterface
{
    private $id;
    private $name;
    private $weight;
    private $count;
    private $price;

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
    public function getWeight(): float
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
}