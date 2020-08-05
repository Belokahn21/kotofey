<?php

namespace app\modules\instagram\controllers;

use app\models\tool\Debug;
use app\modules\instagram\models\tools\Instagram;
use yii\helpers\Json;
use yii\rest\Controller;

class RestBackendController extends Controller
{

	protected function verbs()
	{
		return [
			'get' => ['GET']
		];
	}

	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	public function behaviors()
	{
		return [
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
			],
		];
	}

	public function actionGet()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data = array();
		$media = Instagram::getData();

		foreach ($media->data as $item) {
			@array_push($data, ['title' => $item->caption, 'src' => $item->media_url, 'href' => $item->permalink]);
		}

		return Json::encode($data);
	}
}
