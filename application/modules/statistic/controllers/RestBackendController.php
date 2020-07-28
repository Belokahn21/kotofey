<?php

namespace app\modules\statistic\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\entity\Order;
use app\modules\search\models\entity\SearchQuery;
use yii\helpers\Json;
use yii\web\Controller;
use app\models\tool\Price;
use app\modules\order\models\helpers\OrderHelper;

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
		$products = Product::find();
		$queryData = array();
		$queries = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
		/* @var $query SearchQuery */
		foreach ($queries as $query) {
			$queryData[] = [
				'Запрос' => $query->text,
				'IP' => $query->ip,
				'Дата' => date('d.m.Y H:i', $query->created_at)
			];
		}


		$elements = [
			[
				'icon' => 'fa-clipboard',
				'data' => [
					'Заказов' => Order::find()->count(),
					'Оборот' => Price::format(OrderHelper::income()),
					'Доход' => Price::format(OrderHelper::marginality()),
				],
			],
			[
				'icon' => 'fa-cubes',
				'data' => [
					'Товаров' => $products->where(['>', 'count', 0])->count(),
					'Закуп' => Price::format(ProductHelper::purchaseVirtual($products->where(['>', 'count', 0])->all())),
					'Доход' => Price::format(ProductHelper::profitVirtual($products->where(['>', 'count', 0])->all()))
				],
			],
			[
				'icon' => 'fa-search',
				'data' => [
					'Последний запрос' => SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(10)->one()->text,
				],
				'modal' => [
					'modalId' => 'search-modal-id',
					'title' => 'Поиск сайта',
					'data' => $queryData
				]
			],
		];
		return Json::encode($elements);
	}
}
