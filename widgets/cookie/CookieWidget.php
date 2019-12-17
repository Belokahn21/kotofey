<?php

namespace app\widgets\cookie;


use yii\bootstrap\Widget;

class CookieWidget extends Widget
{
	const COOKIE_SESSION_KEY = 'cookie_read';
	const COOKIE_SESSION_VALUE = 'Y';

	public function run()
	{
		// получение коллекции кук (yii\web\CookieCollection) из компонента "request"
		$cookies = \Yii::$app->request->cookies;
		// получение куки с названием "language. Если кука не существует, "en"  будет возвращено как значение по-умолчанию.
		$cookie = $cookies->getValue(self::COOKIE_SESSION_KEY);
		if ($cookie == self::COOKIE_SESSION_VALUE) {
			return false;
		}
		return $this->render('default');
	}
}