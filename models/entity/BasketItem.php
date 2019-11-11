<?php

namespace app\models\entity;


class BasketItem
{
    private $product_id;
    private $count;
    private $product;

    public function __construct()
    {
        $this->getProduct();
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return Product::findOne($this->getProductId());
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }
}