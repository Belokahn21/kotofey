<?php

namespace app\modules\promocode\controllers;

use yii\rest\Controller;

class RestController extends Controller
{
	public $modelClass = 'app\modules\promocode\models\entity\Promocode';

	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items'
	];

	protected function verbs()
	{
		return [
			'get' => ['GET'],
		];
	}

	public function actionGet($code = null)
	{
		if ($code) {
			return $this->modelClass::findOne(['code' => $code]);
		}
		return $this->modelClass::find()->all();
	}
}