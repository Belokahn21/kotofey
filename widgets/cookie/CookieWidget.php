<?php

namespace app\widgets\cookie;


use yii\bootstrap\Widget;

class CookieWidget extends Widget
{
	const COOKIE_SESSION_KEY = 'cookie_read';
	const COOKIE_SESSION_VALUE = 'Y';

	public function run()
	{
		if (\Yii::$app->session->get(self::COOKIE_SESSION_KEY) == self::COOKIE_SESSION_VALUE) {
			return false;
		}
		return $this->render('default');
	}
}