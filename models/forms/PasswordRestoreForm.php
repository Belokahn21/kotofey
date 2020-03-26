<?php

namespace app\models\forms;


use app\models\entity\User;
use app\models\entity\UserResetPassword;
use yii\base\Model;

class PasswordRestoreForm extends Model
{
	public $email;

	public function rules()
	{
		return [
			[['email'], 'email'],
		];
	}

	public function submit()
	{
		$user = User::findByEmail($this->email);

		if (!$user) {
			return false;
		}


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
}