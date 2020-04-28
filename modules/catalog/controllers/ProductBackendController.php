<?php

namespace app\modules\catalog\controllers;

use Yii;
use app\models\entity\Product;
use app\models\entity\ProductOrder;
use app\models\entity\ProductProperties;
use app\models\search\ProductSearchForm;
use app\widgets\notification\Alert;
use yii\helpers\Url;
use yii\web\Controller;
use yii\widgets\ActiveForm;


class ProductBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
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
