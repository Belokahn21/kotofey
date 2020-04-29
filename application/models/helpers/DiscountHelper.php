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

	public static function addBonus($user_id, $count)
	{
		$discount = Discount::findByUserId($user_id);
		if ($discount) {
			$discount->count += (int)$count;
			if ($discount->validate()) {
				if ($discount->update() !==false) {
					return true;
				}
			}
		}

		return false;
	}
}