<?php

namespace app\modules\menu_fast\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

class RestBackendController extends Controller
{
	protected function verbs()
	{
		return [
			'get' => ['GET']
		];
	}

	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	public function behaviors()
	{
		return [
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
			],
		];
	}

	public function actionGet()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$start = new \DateTime();
		$start->setTime(0, 0, 0);
		$end = new \DateTime();
		$end->setTime(23, 59, 59);

		$menu = [
			[
				'icon' => 'fa-receipt',
				'href' => Url::to(['/admin/order/order-backend/index']),
				'isNewData' => (Order::find()->where([
						'and',
						['>', 'created_at', $start->getTimestamp()],
						['<', 'created_at', $end->getTimestamp()],
					])->count()) > 0
			],
			[
				'icon' => 'fa-cubes',
				'href' => Url::to(['/admin/catalog/product-backend/index']),
				'isNewData' => (Product::find()->where([
						'and',
						['>', 'created_at', $start->getTimestamp()],
						['<', 'created_at', $end->getTimestamp()],
					])->count()) > 0
			],
		];

		return Json::encode($menu);
	}
}
