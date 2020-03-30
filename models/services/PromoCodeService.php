<?php

namespace app\models\services;


class PromoCodeService
{
	public static function isActive()
	{
		return \Yii::$app->params['use_promocode'];
	}
}