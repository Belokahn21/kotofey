<?php

namespace app\modules\order\models\service;


use app\modules\order\models\helpers\TimeDeliveryHelper;
use app\modules\site\models\tools\Debug;
use app\modules\basket\models\tools\BasketHelper;

class DeliveryTimeService
{
	public $format;
	public $current_date;
	public $available_date;
	public $time_list = array();

	public function __construct()
	{
		$this->initOptions();
		$this->getAvailableTimeDelivery($this->current_date);
	}

	public function initOptions()
	{
		$this->format = 'd.m.Y';
		$this->current_date = date($this->format);
	}

	public function getTimeList()
	{
		return $this->time_list;
	}

	public function getAvailableDate()
	{
		return $this->available_date;
	}

	public function getAvailableTimeDelivery($date = null)
	{
		$date = new \DateTime($date);
		while (count($this->time_list) == 0) {

			$this->time_list = $this->getTimes($date->format($this->format));

			if (count($this->time_list) > 0) {
				$this->available_date = $date->format($this->format);
			}

			$date->add(new \DateInterval('P1D'));
		}
	}

	public function getTimes($date)
	{
		$time_list = array();

		if (strtotime($date . " 19:00:00") < time()) {
			return $time_list;
		}

		if (TimeDeliveryHelper::isDeliveryRange($date)) {
			return TimeDeliveryHelper::getNightTimes();
		} elseif (BasketHelper::containVendor(1)) {
			return;
		}


//		if (TimeDeliveryHelper::isHappy($date)) {
//			return $time_list;
//		}

		// вчера и ранее
		if (TimeDeliveryHelper::isOldDay($date)) {
			return $time_list;
		}

		// выходной
		if (TimeDeliveryHelper::isWeekend($date)) {
			return $time_list;
		}

		// сегодня
		if (TimeDeliveryHelper::isNowToday($date)) {

			// если утро прошло, но не наступил вечер
			if (TimeDeliveryHelper::isAfterMorningTime() && TimeDeliveryHelper::isBeforeNightTime()) {
				return $time_list = TimeDeliveryHelper::getNightTimes() + $time_list;
			}
		}

		// если это слеюущий день
		if (TimeDeliveryHelper::isNextDay($date)) {
			return $time_list = TimeDeliveryHelper::getNightTimes() + $time_list;
		} else {
			$time_list = TimeDeliveryHelper::getNightTimes() + $time_list;
			$time_list = TimeDeliveryHelper::getMorningTimes() + $time_list;
		}

		return $time_list;
	}
}