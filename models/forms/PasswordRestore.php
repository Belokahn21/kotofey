<?php

namespace app\models\forms;


use app\models\entity\User;
use app\models\entity\UserResetPassword;
use yii\base\Model;

class PasswordRestore extends Model
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

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						exit();
						return $model->sendNotifyMessage();
					}
				}
			}
		}

		return false;
	}
}