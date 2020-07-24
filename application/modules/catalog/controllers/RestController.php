<?php

namespace app\modules\catalog\controllers;


use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Product;

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
		return new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 30,
//				'pageSizeLimit' => [0, 5],
			]
		]);
	}
}