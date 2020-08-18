<?php

namespace app\modules\promocode\controllers;

use app\widgets\notification\Alert;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\search\PromocodeSearchForm;
use yii\web\HttpException;

class PromocodeBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['Administrator', 'Developer'],
					],
					[
						'allow' => false,
						'roles' => ['?'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	public function actionIndex()
	{
		$model = new Promocode();
		$searchModel = new PromocodeSearchForm();
		$dataProvider = $searchModel->search(Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Промокод успешно добавлен');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('index', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionUpdate($id)
	{
		$model = Promocode::findOne($id);

		if (!$model) {
			throw new HttpException(404, 'Такого промокода не существует.');
		}

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->update()) {
						Alert::setSuccessNotify('Промокод успешно обновлен');
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
