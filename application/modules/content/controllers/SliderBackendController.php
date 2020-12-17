<?php

namespace app\modules\content\controllers;

use app\modules\content\models\entity\Sliders;
use app\modules\content\models\search\SlidersSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class SliderBackendController extends MainBackendController
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
		$model = new Sliders();
		$searchModel = new SlidersSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Слайдер успешно создан');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('index', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	public function actionUpdate($id)
	{
		if (!$model = Sliders::findOne($id)) {
			throw new HttpException(404, 'Слайдер не существует');
		}

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->update()) {
						Alert::setSuccessNotify('Слайдер успешно обновлен');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('update', [
			'model' => $model
		]);
	}

	public function actionDelete($id)
	{
		if (Sliders::findOne($id)->delete()) {
			Alert::setSuccessNotify('Слайдер успешно удален');
		}
		return $this->redirect('index');
	}
}
