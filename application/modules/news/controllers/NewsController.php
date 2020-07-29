<?php

namespace app\modules\news\controllers;


use app\modules\news\models\entity\News;
use yii\web\Controller;

class NewsController extends Controller
{
	public function actionIndex()
	{
		$models = News::find()->all();

		return $this->render('index', [
			'models' => $models
		]);
	}

	public function actionView($id)
	{
		return $this->render('view');
	}
}