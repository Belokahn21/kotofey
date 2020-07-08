<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\modules\catalog\models\entity\Product;

class ProductHelper
{
	/* цена товара за 1 киллограмм */
	public static function getPriceByWeight(Product $product, $weight)
	{
		$product_weight = ProductPropertiesHelper::getProductWeight($product->id);
		$summary_price = 0;
		if (!$product_weight) {
			return false;
		}

		$price_by_one_position_weight = round($product->price / $product_weight);
		$summary_price = round($price_by_one_position_weight * ($weight / 1000));

		return $summary_price;
	}

	public static function getResultPrice(Product $model)
	{
		return ($model->discount_price ? $model->discount_price : $model->price);
	}

	public static function purchaseVirtual(array $products)
	{
		$out = 0;
		/* @var $product Product */
		foreach ($products as $product) {
			$out += $product->count * $product->purchase;
		}

		return $out;
	}
}