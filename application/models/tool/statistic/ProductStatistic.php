<?php

namespace app\models\tool\statistic;


use app\modules\catalog\models\entity\Product;

class ProductStatistic extends Product
{

	public static function tableName()
	{
		return "product";
	}

	public static function countAllProducts()
	{
		return static::find()->count();
	}


	public static function countPurchase()
	{
		return static::find()->sum('purchase');
	}

	public static function income()
	{
		return static::find()->sum('price') - static::find()->sum('purchase');
	}

	public static function realProfit()
	{
		$out = 0;
		$items = Product::find()->where(['>', 'count', 0])->all();

		foreach ($items as $item) {
			$out += $item->count * ($item->price - $item->purchase);
		}

		return $out;
	}
}