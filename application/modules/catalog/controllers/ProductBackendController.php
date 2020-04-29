<?php

namespace app\modules\catalog\controllers;

use Yii;
use app\models\entity\Product;
use app\models\entity\ProductOrder;
use app\widgets\notification\Alert;
use yii\helpers\Url;
use yii\web\Controller;


class ProductBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
		$model = new Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
		$modelDelivery = new ProductOrder();

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Товар усешно добавлен');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('index', [
			'model' => $model,
			'modelDelivery' => $modelDelivery
		]);
	}

	public function actionUpdate()
	{
	}

	public function actionCopy()
	{

	}

	public function actionDelete($id)
	{
		Product::findOne($id)->delete();

		return $this->redirect(Url::to(['index']));
	}
}
