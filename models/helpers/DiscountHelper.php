<?php

namespace app\models\helpers;


use app\models\entity\Discount;

class DiscountHelper
{
	public static function calcBonus($summ)
	{
		return ceil($summ * static::rate());
	}

	public static function rate()
	{
		return Discount::PERCENT_AFTER_SALE / 100;
	}
}