<?php

namespace app\models\services;


use app\models\helpers\TimeDeliveryHelper;
use app\models\tool\Debug;

class DeliveryTimeService
{
	public $date_format;
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
		$this->date_format = 'd.m.Y';
		$this->current_date = date($this->date_format);
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

			$this->time_list = $this->getTimes($date->format($this->date_format));

			if (count($this->time_list) > 0) {
				$this->available_date = $date->format($this->date_format);
			}

			$date->add(new \DateInterval('P1D'));
		}
	}

	public function getTimes($date)
	{
		$time_list = array();

		if (TimeDeliveryHelper::isOldDay($date)) {
			return $time_list;
		}

		if (TimeDeliveryHelper::isWeekend($date)) {
			return $time_list;
		}

		if (TimeDeliveryHelper::isDayToDay($date)) {
			if (TimeDeliveryHelper::isAfterMorningTime() && TimeDeliveryHelper::isBeforeNightTime()) {
				return $time_list = TimeDeliveryHelper::getNightTimes() + $time_list;
			}
		}

		if (TimeDeliveryHelper::isNextDay($date)) {
			return $time_list = TimeDeliveryHelper::getNightTimes() + $time_list;
		} else {
			$time_list = TimeDeliveryHelper::getNightTimes() + $time_list;
			$time_list = TimeDeliveryHelper::getMorningTimes() + $time_list;
		}

		return $time_list;
	}
}