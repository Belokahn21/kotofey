<?php

namespace app\commands;


use app\models\entity\User;
use yii\console\Controller;

class PasswordController extends Controller
{
	public function actionUpdate($identity)
	{
		if (is_numeric($identity)) {
			$user = User::findOne($identity);
		} else {
			$user = User::findByEmail($identity);
		}

		if ($user) {
			$user->scenario = User::SCENARIO_UPDATE;
			$password = md5(time());
			$password = substr($password, 0, 5);
			$user->setPassword($password);

			if ($user->validate()) {
				if ($user->update()) {
					echo "Для пользователя Email: " . $user->email . ' установлен пароль: ' . $password . PHP_EOL . PHP_EOL;
					return true;
				}
			}
		}

		echo "Ошибка" . PHP_EOL . PHP_EOL;
		return false;
	}
}