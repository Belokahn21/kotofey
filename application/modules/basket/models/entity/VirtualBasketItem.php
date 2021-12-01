<?php

namespace app\modules\basket\models\entity;

use app\modules\basket\models\entity\interfaces\BasketItemInterface;
use app\modules\catalog\models\repository\ProductRepository;

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
    private $discount_price;
    private $purchase;
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
        if ($this->product_id) return ProductRepository::getOne($this->product_id);
    }

    public function setDiscountPrice(int $amount)
    {
        $this->discount_price = $amount;
    }

    public function getDiscountPrice()
    {
        return $this->discount_price;
    }

    public function setPurchase(int $amount)
    {
        $this->purchase = $amount;
    }

    public function getPurchase()
    {
        return $this->purchase;
    }
}