<?php

namespace app\modules\bonus\models\services;


class BonusByBuyService
{
	public static function isActive()
	{
		return \Yii::$app->params['bonus_by_buy'];
	}
}