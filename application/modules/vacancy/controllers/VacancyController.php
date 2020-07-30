<?php

namespace app\modules\vacancy\controllers;


use yii\web\Controller;

class VacancyController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}