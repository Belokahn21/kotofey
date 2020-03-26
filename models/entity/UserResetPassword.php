<?php

namespace app\models\entity;

use app\models\tool\System;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class UserResetPassword extends ActiveRecord
{
	const ALIVE_TIME = 1800;

	public function rules()
	{
		return [
			[['user_id', 'key'], 'required'],
			[['user_id'], 'integer'],
			[['key'], 'string'],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	public function setKey()
	{
		$this->key = \Yii::$app->security->generateRandomString(7);
	}

	public function sendNotifyMessage()
	{
		$user = User::findOne($this->user_id);

		if (!$user) {
			return false;
		}

		$link = $this->generateRestoreLink();

		$result = Yii::$app->mailer->compose('restore-password', [
			'link' => $link
		])
			->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
			->setTo($user->email)
			->setSubject('Восстановление пароля')
			->send();

		return $result;
	}

	public function generateRestoreLink()
	{
		return System::domain() . '/restore/' . $this->key;
	}

	public function isAlive()
	{
		return $this->created_at + self::ALIVE_TIME < time();
	}
}