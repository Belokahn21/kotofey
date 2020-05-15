<?php

namespace app\modules\delivery\controllers;

use app\modules\delivery\models\entity\Delivery;
use app\widgets\notification\Alert;
use yii\web\Controller;

class DeliveryBackendController extends Controller
{
	public function actionIndex()
	{
		$model = new Delivery();
		$searchModel = null;
		$dataProvider = null;

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Доставка успешно создана');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('index', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}
}
