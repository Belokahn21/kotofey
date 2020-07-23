<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Product;
use yii\helpers\Json;
use yii\rest\Controller;

class RestController extends Controller
{
	public function actionGet()
	{
		$products = Product::find()->all();
		return Json::encode($products);
	}
}