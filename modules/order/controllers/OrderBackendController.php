<?php

namespace app\modules\order\controllers;

use app\models\entity\Order;
use yii\web\Controller;

class OrderBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
		$model = new Order();
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}
		return $this->render('index', []);
	}
}
