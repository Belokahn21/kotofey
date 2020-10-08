<?php

namespace app\modules\user\models\form;


use app\modules\user\models\entity\User;
use app\modules\user\models\entity\UserResetPassword;
use yii\base\Model;

class PasswordRestoreForm extends Model
{
	public $email;
	public $password;

	const SCENARIO_SEND_MAIL = 1;
	const SCENARIO_UPDATE_PASSWORD = 2;

	public function rules()
	{
		return [
			[['email'], 'required', 'on' => self::SCENARIO_SEND_MAIL, 'message' => 'Укажите почту'],
			[['email'], 'email'],

			[['password'], 'string'],
			[['password'], 'required', 'on' => self::SCENARIO_UPDATE_PASSWORD, 'message' => 'Пароль не должен быть пустым'],
		];
	}

	public function scenarios()
	{
		return [
			self::SCENARIO_SEND_MAIL => ['email'],
			self::SCENARIO_UPDATE_PASSWORD => ['password'],
		];
	}

	public function submit()
	{
		$user = User::findByEmail($this->email);

		if (!$user) {
			return false;
		}

		UserResetPassword::deleteAll(['user_id' => $user->id]);

		$model = new UserResetPassword();
		$model->user_id = $user->id;
		$model->setKey();

		if ($model->validate()) {
			if ($model->save()) {
				return $model->sendNotifyMessage();
			}
		}

		return false;
	}

	public function updatePassword($user_id)
	{
		$user = User::findOne($user_id);
		$user->scenario = User::SCENARIO_UPDATE;
		$user->setPassword($this->password);

		if ($user->validate()) {
			if ($user->update()) {

				\Yii::$app->user->login($user);
				UserResetPassword::deleteAll(['user_id' => $user_id]);
				return true;

			}
		}

		return false;
	}
}