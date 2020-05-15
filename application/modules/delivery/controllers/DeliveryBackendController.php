<?php

namespace app\modules\delivery\controllers;

use app\modules\delivery\models\entity\Delivery;
use app\modules\delivery\models\search\DeliverySearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class DeliveryBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
		$model = new Delivery();
		$searchModel = new DeliverySearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Доставка успешно создана');
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
		if (!$model = Delivery::findOne($id)) {
			throw new HttpException(404, 'Такой доставки не существует');
		}

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->update()) {
						Alert::setSuccessNotify('Доставка успешно обновлена');
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
		if (Delivery::findOne($id)->delete()) {
			Alert::setSuccessNotify('Доставка удалена');
		}
		return $this->redirect('index');
	}
}
