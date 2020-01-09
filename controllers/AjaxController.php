<?php

namespace app\controllers;

use app\models\entity\Basket;
use app\models\entity\BasketItem;
use app\models\entity\Compare;
use app\models\entity\Delivery;
use app\models\entity\Favorite;
use app\models\entity\Geo;
use app\models\entity\ProductProperties;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\TodoList;
use app\models\entity\user\Billing;
use app\models\helpers\ProductPropertiesHelper;
use app\models\services\CompareService;
use app\models\tool\Debug;
use app\models\tool\parser\ParseProvider;
use app\widgets\cookie\CookieWidget;
use app\widgets\notification\NotifyWidget;
use Dadata\Client;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;
use yii\web\HttpException;

class AjaxController extends Controller
{
	public $layout = "ajax";

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
//                    'tobasket' => ['post'],
				],
			],
		];
	}

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionRemoveFromBasket($product_id)
	{
		if (\Yii::$app->request->isAjax) {
			$product = Product::findOne($product_id);
			if (!$product) {
				throw new HttpException(404, 'Товар не найден');
			}

			Basket::getInstance()->delete($product_id);
			if (Basket::getInstance()->delete($product_id) and !Basket::getInstance()->exist($product_id)) {
				return true;
			}
		}
		return false;
	}

	public function actionAddToBasket($product_id, $count)
	{
		if (\Yii::$app->request->isAjax) {
			$product = Product::findOne($product_id);
			if (!$product) {
				throw new HttpException(404, 'Товар не найден');
			}

			if (!$product->vitrine) {
				if ($product->count - $count <= 0) {
					return false;
				}
			}

			$basketItem = new BasketItem();
			$basketItem->setProductId($product->id);
			$basketItem->setCount($count);
			$basketItem->setPrice($product->price);
			$basketItem->setName($product->name);

			$basket = new Basket();
			if ($basket->exist($basketItem->getProductId())) {
				$basket->update($basketItem, $count);
			} else {
				$basket->add($basketItem);
			}

			return true;
		}

		return false;
	}

	public function actionAddToFavorite($product_id)
	{
		if (!\Yii::$app->request->isAjax) {
			return false;
		}

		if (Favorite::getInstance()->exist($product_id)) {
			Favorite::getInstance()->delete($product_id);
		} else {
			Favorite::getInstance()->add($product_id);
		}
		return true;
	}

	public function actionTobasket()
	{
		if (\Yii::$app->request->isPost) {

			$POST = \Yii::$app->request->post();
			$product = Product::findOne($POST['id']);
			if (($product->count - 1) >= 0) {
				$basket = new Basket();
				$basket->product = Product::findOne($POST['id']);
				$basket->count = 1;
				$basket->add();

				$result = [
					'status' => true,
					'htmlData' => $this->renderFile('@app/views/ajax/basket.php'),
				];
			} else {
				$result = [
					'status' => false,
				];
			}


			return Json::encode($result);
		} else {

			$GET = \Yii::$app->request->get();
			$product = Product::findOne($GET['id']);
			if (($product->count - 1) >= 0) {

				$basket = new Basket();
				$basket->product = Product::findOne($GET['id']);
				$basket->count = 1;
				$basket->add();

			}

		}
	}

	public function actionRemovetodo()
	{
		$POST = \Yii::$app->request->post();
		return Json::encode(TodoList::findOne($POST['id'])->delete());
	}

	public function actionClosetodo()
	{
		$POST = \Yii::$app->request->post();
		$todoObject = TodoList::findOne($POST['id']);
		$todoObject->close = !$todoObject->close;
		return Json::encode($todoObject->update());
	}

	public function actionFilter()
	{

		if (!array_key_exists('CatalogFilter', $_POST)) {
			throw new \Exception('Массив днных не пришёл');
		}
		$form = $_POST['CatalogFilter'];
		$ar_bank_products_ids = array();
		$arKeyToPropertyId = array(
			'company' => 1,
			'type' => 3,
			'line' => 4,
			'taste' => 5,
		);

		foreach ($arKeyToPropertyId as $key => $id) {

			if (array_key_exists($key, $form) && !empty($form[$key])) {

				$query = ProductPropertiesValues::find()->where([
					'value' => $form[$key],
					'property_id' => $id
				])->select(['product_id'])->all();

				$arListIds = ArrayHelper::getColumn($query, 'product_id');


				if (count($ar_bank_products_ids) > 0) {
					$ar_bank_products_ids = array_intersect($arListIds, $ar_bank_products_ids);
				} else {
					$ar_bank_products_ids = $arListIds;
				}

			}
		}


		return Json::encode([
//            'company' => $selectCompany
		]);
	}

	public function actionLoader()
	{
		if (!\Yii::$app->request->isAjax) {
			return false;
		}

		$url = $_REQUEST['url'];


		$parser = new ParseProvider($url);
		$parser->contract();
		return Json::encode($parser->getInfo());
	}

	public function actionSetCityId($id)
	{
		if (!\Yii::$app->request->isAjax) {
			return false;
		}
		$city_id = $_REQUEST['id'];

		$geo = Geo::findOne($city_id);
		if (!$geo) {
			throw new \Exception('Error find');
		}

		\Yii::$app->session->set('city_id', $city_id);

		return true;


	}

	public function actionAcceptCookie()
	{
		if (!\Yii::$app->request->isAjax) {
			return false;
		}

		// получение коллекции (yii\web\CookieCollection) из компонента "response"
		$cookies = \Yii::$app->response->cookies;

		// добавление новой куки в HTTP-ответ
		$cookies->add(new \yii\web\Cookie([
			'name' => CookieWidget::COOKIE_SESSION_KEY,
			'value' => CookieWidget::COOKIE_SESSION_VALUE,
		]));
		$cookies = \Yii::$app->request->cookies;
		// получение куки с названием "language. Если кука не существует, "en"  будет возвращено как значение по-умолчанию.
		$cookie = $cookies->getValue(CookieWidget::COOKIE_SESSION_KEY);
		if ($cookie == CookieWidget::COOKIE_SESSION_VALUE) {
			return true;
		}
		return false;
	}

	public function actionHideNotify()
	{
		if (!\Yii::$app->request->isAjax) {
			return false;
		}

		// получение коллекции (yii\web\CookieCollection) из компонента "response"
		$cookies = \Yii::$app->response->cookies;

		// добавление новой куки в HTTP-ответ
		$cookies->add(new \yii\web\Cookie([
			'name' => NotifyWidget::COOKIE_NOTIFY_KEY,
			'value' => NotifyWidget::COOKIE_NOTIFY_VALUE,
		]));
		$cookies = \Yii::$app->request->cookies;
		// получение куки с названием "language. Если кука не существует, "en"  будет возвращено как значение по-умолчанию.
		$cookie = $cookies->getValue(NotifyWidget::COOKIE_NOTIFY_KEY);
		if ($cookie == NotifyWidget::COOKIE_NOTIFY_VALUE) {
			return true;
		}
		return false;
	}

	public function actionToCompare($product_id)
	{
		$response = array();
		$compare = new Compare();
		$compare->product_id = $product_id;

		if ($compare->save()) {
			$response['code'] = "success";
			$response['message'] = "Товар добавлен в список сравнения";
			$response['other'] = [
				'count' => CompareService::count()
			];
		}
		return Json::encode($response);
	}

	public function actionBilling($product_id)
	{
		if (\Yii::$app->user->isGuest or !\Yii::$app->request->isAjax) {
			return false;
		}
		$billing = Billing::findOne($product_id);

		if (!$billing) {
			throw new HttpException(404, 'Элемент не найден');
		}

		$response = [
			'code' => 'success',
			'message' => 'Адрес доставки: `' . $billing->getName() . '` выбран основным'
		];

		foreach (Billing::find()->where(['user_id' => \Yii::$app->user->id])->all() as $change_billing) {
			$change_billing->is_main = false;
			if ($change_billing->validate()) {
				if (!$change_billing->update()) {
					$response = [
						'code' => 'error',
						'message' => 'Ошибка при общей смене статуса доставки'
					];
				}
			} else {
				$response = [
					'code' => 'error',
					'message' => 'Ошибка валидации обновления адресов'
				];
			}
		}

		$billing->is_main = true;
		if ($billing->validate()) {
			if (!$billing->update()) {
				$response = [
					'code' => 'error',
					'message' => 'Ошибка при обновлении адреса доставки'
				];
			}
		} else {
			$response = [
				'code' => 'error',
				'message' => 'Ошибка валидации обновления адреса (' . implode('-', $billing->getErrors()) . ')'
			];
		}


		return Json::encode($response);
	}

	public function actionBuyWeight()
	{
		if (!\Yii::$app->request->isAjax) {
			return false;
		}

		$request_data = $_POST;
		$product_id = $request_data['product_id'];

		$product = Product::findOne($product_id);
		if (!$product) {
			throw new HttpException(404, 'Элемент не найден');
		}

		// todo: проверка на возможность покупать на разнавес по свойству is_wegiht

		$product_weight = ProductPropertiesHelper::getProductWeight($product->id);
		if (!$product_weight) {
			return false;
		}

		$price_by_one_position_weight = round($product->price / $product_weight);
		$summary_price = round($price_by_one_position_weight * ($request_data['weight'] / 1000));

		$data = array(
			'summary_price' => $summary_price,
		);


		return Json::encode($data);
	}
}
