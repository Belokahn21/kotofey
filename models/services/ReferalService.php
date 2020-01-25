<?php

namespace app\models\services;


use app\models\entity\UsersReferal;

class ReferalService
{
	const REFERAL_COOKIE_KEY = 'referal_key';

	/**
	 * @return bool
	 */
	public function saveKeyToGuest()
	{
		$referal_key = \Yii::$app->request->get('ref');


		if (empty($referal_key)) {
			return false;
		}

		$referal = UsersReferal::findOneByKey($referal_key);
		if (!$referal) {
			return false;
		}

		\Yii::$app->response->cookies->add(new \yii\web\Cookie([
			'name' => self::REFERAL_COOKIE_KEY,
			'value' => $referal_key,
		]));


		return true;
	}

	public function destroyKeyGuest()
	{
		\Yii::$app->response->cookies->remove(self::REFERAL_COOKIE_KEY);
		return true;
	}

	/**
	 * @return bool|string
	 */
	public function getCookieValue()
	{
		$cookies = \Yii::$app->request->cookies;
		if (($cookie = $cookies->get(ReferalService::REFERAL_COOKIE_KEY)) !== null) {
			return $cookie->value;
		}

		return false;
	}

	/**
	 * @return ReferalService
	 */
	public static function getInstance()
	{
		return new ReferalService();
	}
}