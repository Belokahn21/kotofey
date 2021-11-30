<?php

namespace app\modules\order\models\helpers;

use app\modules\basket\models\helpers\BasketHelper as BasketHelperAlias;

class TimeDeliveryHelper
{
	const MAX_DELIVERIES_IN_ONE_HOUR = 2;

	// morning
	const STEP_HOUR_MORNING = 2;
	const START_HOUR_MORNING = 7;
	const END_HOUR_MORNING = 9;

	// night
	const STEP_HOUR_NIGHT = 1;
	const START_HOUR_NIGHT = 19;
	const END_HOUR_NIGHT = 22;

	public static function isNextDay($date)
	{
		return abs(date('d', strtotime(date('d.m.Y'))) - date('d', strtotime($date))) == 1;
	}

	public static function isNowToday($date)
	{
		return strtotime($date) == strtotime(date('d.m.Y'));
	}

	public static function isOldDay($date)
	{
		return strtotime(date('d.m.Y')) > strtotime($date);
	}

	public static function isWeekend($date)
	{
		$unix_date = strtotime($date);

		return date('N', $unix_date) == 6 or date('N', $unix_date) == 7;
	}

	public static function isMorningTime()
	{
		$current_hour = date('H');
		if ($current_hour <= self::START_HOUR_MORNING and $current_hour >= self::END_HOUR_MORNING) {
			return true;
		}

		return false;
	}

	public static function isBeforeMorningTime()
	{
		$current_hour = date('H');
		if ($current_hour <= self::START_HOUR_MORNING) {
			return true;
		}
		return false;
	}

	public static function isAfterMorningTime()
	{
		$current_hour = date('H');
		if ($current_hour >= self::END_HOUR_MORNING) {
			return true;
		}
		return false;
	}

	public static function isNightTime()
	{
		$current_hour = date('H');
		if ($current_hour >= self::START_HOUR_NIGHT and $current_hour <= self::END_HOUR_NIGHT) {
			return true;
		}

		return false;
	}


	public static function isBeforeNightTime()
	{
		$current_hour = date('H');
		if ($current_hour <= self::START_HOUR_NIGHT) {
			return true;
		}
		return false;
	}

	public static function isAfterNightTime()
	{
		$current_hour = date('H');
		if ($current_hour >= self::END_HOUR_NIGHT) {
			return true;
		}
		return false;
	}

	public static function getMorningTimes()
	{
		$times = [];
		for ($i = self::START_HOUR_MORNING; $i <= self::END_HOUR_MORNING; $i++) {
			$times[$i] = $i + self::STEP_HOUR_MORNING;
		}
		return $times;
	}

	public static function getNightTimes()
	{
		$times = array();
		for ($i = self::START_HOUR_NIGHT; $i < self::END_HOUR_NIGHT; $i++) {
			$times[$i] = $i + self::STEP_HOUR_NIGHT;
		}

		return $times;
	}

	public static function isDeliveryRange($date)
	{
		if (BasketHelperAlias::containVendor(1)) {
			$numberDay = date('N', strtotime($date));

			if ($numberDay > 1 and $numberDay < 3) {
				return false;
			}

			if ($numberDay < 3 and $numberDay > 5) {
				return false;
			}

			if ($numberDay > 5) {
				return false;
			}

			return true;
		}

		return false;
	}

	public static function isHappy($date)
	{
		$unix = strtotime($date);

		$ranges = [
			[
				'01.05',
				'05.05'
			],
			[
				'09.05',
				'11.05'
			],
			[
				'25.12',
				'31.12',
			],
			[
				'01.01',
				'09.01',
			],
		];

		foreach ($ranges as $block => $dates) {
		}


		return false;
	}
}