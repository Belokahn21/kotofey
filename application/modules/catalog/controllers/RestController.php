<?php

namespace app\modules\catalog\controllers;


use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\rest\Controller;

class RestController extends ActiveController
{
	public $modelClass = 'app\modules\catalog\models\entity\Product';

	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items'
	];

	protected function verbs()
	{
		return [
			'get' => ['POST'],
		];
	}

	public function actionGet()
	{
		$catalogFilter = new CatalogFilter();
		$query = Product::find();
		$catalogFilter->applyFilter($query, \Yii::$app->request->post());
//		$products = $query->all();
		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 30,
//				'pageSizeLimit' => [0, 5],
			]
		]);
//		return Json::encode($products);
	}
}