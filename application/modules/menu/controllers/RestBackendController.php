<?php

namespace app\modules\menu\controllers;

use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

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
		$menu = array();

		$menu = [
			['title' => 'Главная стрница', 'href' => '/'],
			['title' => 'Рабочий стол', 'href' => '/admin/'],
			['title' => 'Города', 'href' => Url::to(['/admin/geo/geo-backend/index'])],
			['title' => 'Временные зоны', 'href' => Url::to(['/admin/geo/timezone-backend/index'])],
			['title' => 'Товары', 'href' => Url::to(['/admin/catalog/product-backend/index'])],
			['title' => 'Разделы', 'href' => Url::to(['/admin/catalog/product-category-backend/index'])],
			['title' => 'Свойства', 'href' => Url::to(['/admin/catalog/product-properties-backend/index'])],
			['title' => 'Справочники', 'href' => Url::to(['/admin/catalog/product-informer-backend/index'])],
			['title' => 'Значения справочников', 'href' => Url::to(['/admin/catalog/product-informer-value-backend/index'])],
		];

		return Json::encode($menu);
	}
}
