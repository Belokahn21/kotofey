<?php

namespace app\modules\compare\controllers;

use app\modules\compare\models\entity\Compare;
use yii\rest\Controller;

class RestController extends Controller
{
	protected function verbs()
	{
		return [
			'add' => ['POST'],
		];
	}

	public function actionAdd()
	{
		$data = \Yii::$app->request->post();
		$compare = new Compare();
		$compare->product_id = $data['product_id'];
		$compare->save();
		return true;
	}
}