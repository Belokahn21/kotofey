<?php

namespace app\models\entity;


use app\models\helpers\BasketHelper;
use app\models\tool\Debug;
use app\modules\order\models\entity\OrdersItems;
use yii\base\Model;

/**
 * Basket model
 *
 * @property Product $product
 * @property integer $count
 * @property Promo $promo
 */
class Basket extends Model
{
	const EVENT_AFTER_ADD_ITEM = 'item_add';

	public static function getInstance()
	{
		return new Basket();
	}

	public function __construct($config = [])
	{
		parent::__construct($config);

		\Yii::$app->session->open();
	}

	public function add(OrdersItems $item)
	{
		$_SESSION['basket'][$item->product_id] = $item;
	}

	public function delete($product_id)
	{
		unset($_SESSION['basket'][$product_id]);
		return true;
	}

	/**
	 * @param $product_id
	 * @return OrdersItems
	 */
	public static function findOne($product_id)
	{
		$basket = \Yii::$app->session->get('basket');
		if ($basket !== null) {
			if (array_key_exists($product_id, $basket)) {
				return $basket[$product_id];
			}
		}

		return new OrdersItems();
	}

	public function update(OrdersItems $item, $count)
	{
		/* @var $item OrdersItems */
		if ($item = $_SESSION['basket'][$item->product_id]) {
			$item->count = $count;
		}

		$_SESSION['basket'][$item->product_id] = $item;
	}

	public function exist($product_id)
	{
		\Yii::$app->session->open();
		$basket = \Yii::$app->session->get('basket');
		if ($basket !== null) {
			if (array_key_exists($product_id, $basket)) {
				return true;
			}
		}
		return false;
	}

	public static function findAll()
	{
		$items = false;
		if ($basket = \Yii::$app->session->get('basket')) {
			$items = array();
			foreach ($basket as $product_id => $item) {
				$items[$product_id] = $item;
			}
		}

		return $items;
	}

	public static function clear()
	{
		unset($_SESSION['basket']);
	}

	public static function count()
	{
		if (\Yii::$app->session->get('basket')) {
			return count(\Yii::$app->session->get('basket'));
		}
		return false;
	}

	public function isEmpty()
	{
		$basket = \Yii::$app->session->get('basket');
		if ($basket) {
			if (count($basket) > 0) {
				return false;
			}
		}

		return true;
	}


	public function cash()
	{
		$cash = 0;

		/* @var $promo Promo */
		if (!empty($_SESSION['basket'])) {
			/* @var $item OrdersItems */
			foreach ($_SESSION['basket'] as $id => $item) {
				$cash += $item->price * $item->count;
			}
		}

		return $cash;
	}
}