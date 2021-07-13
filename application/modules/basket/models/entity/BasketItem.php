<?php

namespace app\modules\basket\models\entity;


use app\modules\catalog\models\entity\Offers;

class BasketItem
{
	private $name;
	private $product_id;
	private $count;
	private $price;
	private $weight;
	private $image;

	/**
	 * @return mixed
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @return mixed
	 */
	public function getWeight()
	{
		return $this->weight;
	}

	/**
	 * @param mixed $image
	 */
	public function setImage($image)
	{
		$this->image = $image;
	}

	/**
	 * @param mixed $weight
	 */
	public function setWeight($weight)
	{
		$this->weight = $weight;
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
		return Offers::findOne($this->getProductId());
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