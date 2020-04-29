<?php

namespace app\models\helpers;


use app\models\entity\Product;
use app\models\entity\ProductPropertiesValues;
use yii\web\HttpException;

class ProductPropertiesHelper
{
	public static function getProductWeight($product_id)
	{
		$product = Product::findOne($product_id);
		if (!$product) {
			throw new HttpException(404, 'Элемент не найден');
		}

		$weight = ProductPropertiesValues::findOne(['property_id' => 2, 'product_id' => $product->id]);
		if ($weight) {
			return $weight->value;
		}


		return false;
	}
}