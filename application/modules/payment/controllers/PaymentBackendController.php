<?php

namespace app\modules\payment\controllers;

use app\widgets\notification\Alert;
use yii\web\Controller;

class PaymentBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
		$model = null;
		$searchModel = null;
		$dataProvider = null;

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Способ оплаты создан');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('index', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}
	public function actionUpdate($id)
	{
		$model = null;
		$searchModel = null;
		$dataProvider = null;

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->update()) {
						Alert::setSuccessNotify('Способ оплаты обновлен');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}
}
