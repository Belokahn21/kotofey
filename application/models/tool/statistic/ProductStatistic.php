<?php

namespace app\models\tool\statistic;


use app\models\entity\Product;

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
}