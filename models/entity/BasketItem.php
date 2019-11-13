<?php

namespace app\models\entity;


class BasketItem
{
	private $name;
	private $product_id;
	private $count;
	private $price;

	public function __construct()
	{
	}

	/**
	 * @param mixed $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * @return mixed
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
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