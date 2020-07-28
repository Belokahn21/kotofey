<?php

namespace app\modules\subscibe\controllers;

use app\modules\subscibe\models\entity\Subscribe;
use app\widgets\notification\Alert;
use yii\web\Controller;

class SubscribeController extends Controller
{
	public function actionCreate()
	{
		$model = new Subscribe();
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
