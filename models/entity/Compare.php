<?php

namespace app\models\entity;


class Compare
{
	const COMPARE_SESSION_KEY = 'compare';

	public $product_id;

	public function save()
	{
		$product = Product::findOne($this->product_id);
		if (!$product) {
			return false;
		}

		$_SESSION[self::COMPARE_SESSION_KEY][$product->id] = $product;

		if (array_key_exists(self::COMPARE_SESSION_KEY, $_SESSION)) {
			if (array_key_exists($product->id, $_SESSION[self::COMPARE_SESSION_KEY])) {
				return true;
			}
		}

		return false;
	}

	public static function findAll()
	{
		$items = array();
		if ($compare = \Yii::$app->session->get(self::COMPARE_SESSION_KEY)) {
			foreach ($compare as $product_id => $item) {
				$items[] = Product::findOne($product_id);
			}
		}
		return $items;
	}
}