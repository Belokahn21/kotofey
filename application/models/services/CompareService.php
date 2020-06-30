<?php

namespace app\models\services;


use app\modules\compare\models\entity\Compare;

class CompareService
{
	public static function count()
	{
		return count(\Yii::$app->session->get(Compare::COMPARE_SESSION_KEY));
	}
}