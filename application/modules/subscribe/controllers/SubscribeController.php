<?php

namespace app\modules\subscribe\controllers;

use app\modules\subscribe\models\entity\Subscribes;
use app\widgets\notification\Alert;
use yii\web\Controller;

class SubscribeController extends Controller
{
	public function actionCreate()
	{
		$model = new Subscribes();
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Вы подписались на обновления. Отменить подписку можно в личном кабинете.');
					}
				}
			}
		}
		return $this->redirect(['/']);
	}
}
