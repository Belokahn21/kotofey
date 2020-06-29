<?php

namespace app\modules\yandex\controllers;

use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\Product;
use app\models\tool\Debug;
use yii\web\Controller;

class CatalogController extends Controller
{
	public function actionExport()
	{
		$categories = Category::find()->all();
		$offers = Product::find()->where(['active' => 1])->all();

		\Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		\Yii::$app->response->headers->add('Content-Type', 'text/xml');


		$response = $this->renderPartial('export', [
			'offers' => $offers,
			'categories' => $categories
		]);

		return $response;
	}

	public function getXmlHead()
	{
		return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL;
	}
}
