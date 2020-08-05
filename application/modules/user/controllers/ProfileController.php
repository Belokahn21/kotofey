<?php

namespace app\modules\user\controllers;


use app\modules\order\models\entity\Order;
use app\modules\user\models\entity\User;
use app\modules\user\models\entity\UserSex;
use yii\web\Controller;

class ProfileController extends Controller
{
	public function actionIndex()
	{
		$orders = Order::find()->where(['phone' => \Yii::$app->user->identity->phone])->all();
		$model = User::findOne(\Yii::$app->user->id);
		$sexList = UserSex::find()->all();

		return $this->render('index', [
			'orders' => $orders,
			'model' => $model,
			'sexList' => $sexList
		]);
	}

	public function actionLogout()
	{
		\Yii::$app->user->logout();
		return $this->redirect(['/']);
	}
}