<?php

namespace app\modules\export\controllers;

use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use yii\web\Controller;

class YmlController extends Controller
{
	public function actionIndex()
	{
		$categories = ProductCategory::find()->all();
		$offers = Product::find()->where(['status_id' => Product::STATUS_ACTIVE])->all();

//		\Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//		\Yii::$app->response->headers->add('Content-Type', 'text/xml');


		$response = $this->renderPartial('index', [
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
