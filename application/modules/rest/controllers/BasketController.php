<?php

namespace app\modules\rest\controllers;

use yii\helpers\Json;
use yii\rest\Controller;

class BasketController extends Controller
{
	const ERROR_CODE = 400;
	const SUCCESS_CODE = 200;

	protected function verbs()
	{
		return [
			'get' => ['GET'],
			'post' => ['POST'],
		];
	}

	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	public function actionPost()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


		return Json::encode(['code' => self::SUCCESS_CODE, 'message' => 'Товар успешно добавлен в корзину']);
	}
}