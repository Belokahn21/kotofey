<?php

namespace app\modules\compare\models\service;


use app\modules\compare\models\entity\Compare;

class CompareService
{
	public static function count()
	{
		return count(\Yii::$app->session->get(Compare::COMPARE_SESSION_KEY));
	}
}