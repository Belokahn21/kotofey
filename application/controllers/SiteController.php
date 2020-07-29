<?php

namespace app\controllers;

use app\modules\support\models\entity\SupportCategory;
use app\modules\user\models\entity\Auth;
use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Category;
use app\modules\favorite\models\entity\Favorite;
use app\modules\geo\models\entity\Geo;
use app\modules\catalog\models\entity\InformersValues;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\news\models\entity\News;
use app\modules\news\models\entity\NewsCategory;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductProperties;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\promo\models\entity\Promo;
use app\modules\short_link\models\entity\ShortLinks;
use app\modules\user\models\entity\Billing;
use app\modules\user\models\entity\UserResetPassword;
use app\modules\vacancy\models\entity\Vacancy;
use app\models\forms\CatalogFilter;
use app\modules\user\models\form\PasswordRestoreForm;
use app\models\services\ReferalService;
use app\models\tool\Debug;
use app\models\tool\seo\Attributes;
use app\modules\user\models\entity\User;
use app\models\tool\seo\og\OpenGraph;
use app\models\tool\seo\og\OpenGraphProduct;
use app\models\tool\System;
use app\widgets\notification\Alert;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii\web\HttpException;
use yii\web\Response;
use app\modules\geo\models\entity\CurrentGeo;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
	public function behaviors()
	{
		// @ - auth user
		// ? - guest user
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'profile', 'support', 'test', 'order'],
				'rules' => [
					[
						'actions' => ['order'],
						'allow' => false,
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['profile'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['profile', 'support'],
						'allow' => false,
						'roles' => ['?'],
					],
					[
						'actions' => ['test'],
						'allow' => true,
						'roles' => ['Developer'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
//                    'success' => ['post'],
//                    'fail' => ['post'],
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
			'auth' => [
				'class' => 'yii\authclient\AuthAction',
				'successCallback' => [$this, 'onAuthSuccess'],
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function onAuthSuccess($client)
	{
		$attributes = $client->getUserAttributes();

		/* @var $auth Auth */
		$auth = Auth::find()->where([
			'source' => $client->getId(),
			'source_id' => $attributes['id'],
		])->one();

		if (Yii::$app->user->isGuest) {
			if ($auth) { // авторизация
				$user = $auth->user;
				Yii::$app->user->login($user);
			} else { // регистрация
				if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
					Yii::$app->getSession()->setFlash('error', [
						Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не связан. Для начала войдите на сайт использую электронную почту, для того, что бы связать её.", ['client' => $client->getTitle()]),
					]);
				} else {
					$password = Yii::$app->security->generateRandomString(6);
					$user = new User([
						'email' => $attributes['email'],
						'password' => $password,
					]);
					$user->generateAuthKey();
					$user->generatePasswordResetToken();
					$transaction = $user->getDb()->beginTransaction();
					if ($user->save()) {
						$auth = new Auth([
							'user_id' => $user->id,
							'source' => $client->getId(),
							'source_id' => (string)$attributes['id'],
						]);
						if ($auth->save()) {
							$transaction->commit();
							Yii::$app->user->login($user);
						} else {
							print_r($auth->getErrors());
						}
					} else {
						print_r($user->getErrors());
					}
				}
			}
		} else { // Пользователь уже зарегистрирован
			if (!$auth) { // добавляем внешний сервис аутентификации
				$auth = new Auth([
					'user_id' => Yii::$app->user->id,
					'source' => $client->getId(),
					'source_id' => $attributes['id'],
				]);
				$auth->save();
			}
		}
	}


	public function beforeAction($action)
	{
		if (in_array($action->id, ['success', 'fail', 'test'])) {
			$this->enableCsrfValidation = false;
		}

		if (!Yii::$app->session->get('city_id')) {
			$CityDefault = Geo::find()->where(['is_default' => true])->one();
			if ($CityDefault) {
				Yii::$app->session->set('city_id', $CityDefault->id);
			}
		}


		$geo = CurrentGeo::find()->one();
		if ($geo) {
			if ($geo->timeZone) {
				date_default_timezone_set($geo->timeZone->value);
			}
		}


		$referal = new ReferalService();
		$referal->saveKeyToGuest();


		return parent::beforeAction($action);
	}

	public function actionIndex()
	{
		Attributes::metaDescription("Зоотовары онлайн с доставкой по Барнаулу и по всей России. Всегда свежие товары и по низкой цене!");
		Attributes::metaKeywords([
			"интернет магазин зоотоваров",
			"магазин зоотоваров барнаул",
			"интернет магазин зоотоваров барнаул",
			"сибагро барнаул зоотовары прайс",
		]);

		return $this->render('index');
	}

	public function actionCatalog($id = null)
	{
		// need reidrect?
		$link = ShortLinks::findOne(['short_code' => $id]);
		if ($link) {

			$link->visits += 1;
			$link->update();

			return $this->redirect($link->link, 301);
		}

		$filterModel = new CatalogFilter();
		$category = Category::findBySlug($id);
		if ($category) {
			$sb = $category->subsections();
		}
		if ($id) {
			$query = Product::find()->orderBy(['created_at' => SORT_DESC]);

			if ($sb) {
				$query->where(['category_id' => ArrayHelper::getColumn($sb, 'id')]);
			}

			$query->andWhere(['active' => 1]);
		} else {
			$query = Product::find()->orderBy(['created_at' => SORT_DESC])->andWhere(['active' => 1]);
		}

		$filterModel->applyFilter($query, Yii::$app->request->get());
		$countQuery = clone $query;
		$pagerItems = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
		$pagerItems->pageSizeParam = false;
		$products = $query->offset($pagerItems->offset)->limit($pagerItems->limit)->all();

		if (!empty($category->seo_keywords)) {
			$keywords = $category->seo_keywords;
		} else {
			$keywords = [
				"зоотовары каталог",
				"каталог магазина зоотоваров",
				"валта зоотовары каталог",
				"магазин зоотоваров",
				"интернет магазин зоотоваров",
				"купить зоотовары в интернет магазине",
				"магазин зоотоваров барнаул",
				"зоотовары интернет магазин барнаул",
				"альф барнаул зоотовары",
			];
		}

		if (!empty($category->seo_description)) {
			$description = $category->seo_description;
		} else {
			$description = "Большой выбор товара в наличии корма для домашних животных. Бесплатная доставка по городу Баранул при заказе от 500 рублей.";
		}

		if ($category) {
			$canonical = System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $category->slug . "/";
		} else {
			$canonical = System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/";
		}
		Attributes::metaDescription($description);
		Attributes::metaKeywords($keywords);
		Attributes::canonical($canonical);


		return $this->render('catalog', [
			'pagerItems' => $pagerItems,
			'products' => $products,
			'category' => $category,
		]);
	}

	public function actionProduct($id = null)
	{
	}

	public function actionBasket()
	{
		Attributes::metaDescription('Корзина товаров в интернет магазине Котофей');
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('basket');
	}

	public function actionProfile($id = null)
	{
		if ($id) {
			$user = User::findOne($id);
			return $this->render('detail/profile', [
				'user' => $user
			]);
		} else {
			$userId = \Yii::$app->user->id;
			$profile = User::findOne($userId);
			$profile->scenario = User::SCENARIO_UPDATE;
			$orders = Order::find()->where(['user_id' => $profile->id])->orderBy(['created_at' => SORT_DESC])->all();
			$support_categories = SupportCategory::find()->all();
			Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

			if (\Yii::$app->request->isPost) {
				if ($profile->load(\Yii::$app->request->post())) {
					if ($profile->validate()) {
						$profile->update();
					}
				}
				if ($profile->billing->load(\Yii::$app->request->post())) {
					if ($profile->billing->validate()) {
						if ($profile->billing->update()) {
							$profile->billing->update();
						}
					}
				}

				Alert::setSuccessNotify('Данные успешно обновлены');
				return $this->refresh();
			}

			return $this->render('profile', [
				'profile' => $profile,
				'orders' => $orders,
				'support_categories' => $support_categories
			]);
		}
	}

	public
	function actionBilling(
		$id = null
	) {
		if ($id) {
			$model = Billing::find()->where(['user_id' => Yii::$app->user->id, 'id' => $id])->one();

			if (!$model) {
				throw new HttpException(404, 'Адрес не найден');
			}

			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Адрес доставки успешно обновлён');
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/billing', [
				'model' => $model
			]);
		}
		$models = Billing::find()->where(['user_id' => Yii::$app->user->id])->all();
		return $this->render('billing', [
			'models' => $models
		]);
	}

	public
	function actionSignin()
	{
		$model = new User(['scenario' => User::SCENARIO_LOGIN]);
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {

					$user = User::findByEmail($model->email);
					if ($user instanceof User && $user->validatePassword($model->password)) {
						if (Yii::$app->user->login($user, Yii::$app->params['users']['rememberMeDuration'])) {
							Alert::setSuccessNotify('Успешная авторизация');
							return $this->redirect('/');
						}
					}

				}
			}
		}

		Attributes::metaDescription('Вход на сайт интернет магазина Котофей');
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

		return $this->render('auth/signin', [
			'model' => $model,
		]);
	}

	public
	function actionSignup()
	{
		$model = new User(['scenario' => User::SCENARIO_INSERT]);

		// validate for ajax request
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					$model->setPassword($model->password);
					if ($model->save()) {
						if (Yii::$app->user->login($model, Yii::$app->params['users']['rememberMeDuration'])) {
							Alert::setSuccessNotify("Успешная регистрация!");
							return $this->redirect("/");
						}
					} else {
						Alert::setErrorNotify(Debug::modelErrors($model));
						return $this->refresh();
					}
				} else {
					Alert::setErrorNotify(Debug::modelErrors($model));
					return $this->refresh();

				}
			}
		}


		return $this->render('auth/signup', [
			'model' => $model,
		]);
	}

	public
	function actionPayment()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		Attributes::metaDescription("Условия оплаты заказов на нашем сайте");
		Attributes::metaKeywords([
			"зоотовары каталог",
			"каталог магазина зоотоваров",
			"валта зоотовары каталог",
			"магазин зоотоваров",
			"интернет магазин зоотоваров",
			"купить зоотовары в интернет магазине",
			"магазин зоотоваров барнаул",
			"зоотовары интернет магазин барнаул",
			"альф барнаул зоотовары",
		]);
		return $this->render('payment');
	}

	public
	function actionDelivery()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		Attributes::metaDescription("Условия доставки заказов на нашем сайте");
		Attributes::metaKeywords([
			"зоотовары каталог",
			"каталог магазина зоотоваров",
			"валта зоотовары каталог",
			"магазин зоотоваров",
			"интернет магазин зоотоваров",
			"купить зоотовары в интернет магазине",
			"магазин зоотоваров барнаул",
			"зоотовары интернет магазин барнаул",
			"альф барнаул зоотовары",
		]);

		return $this->render('delivery');
	}



	public
	function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}

	public function actionTest()
	{
        $string = Yii::$app->request->post('string');
        $stringHash = '';
        if (!is_null($string)) {
            $stringHash = rand();
        }
        return $this->render('test', [
            'stringHash' => $stringHash,
        ]);
	}

	public
	function actionFavorite()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		$products = Favorite::listProducts();
		return $this->render('favorite', [
			'products' => $products
		]);
	}

	public function actionFaq()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		Attributes::metaDescription("Система быстрой помощи по сайту, в которой можно найти ответы на вопросы, которые возникил в ходе посещения вами нашего сайта. Если вы не найдете ответ на вопрос, то оставьте заявку и мы вам перезвоним");
		Attributes::metaKeywords([
			"зоотовары каталог",
			"каталог магазина зоотоваров",
			"валта зоотовары каталог",
			"магазин зоотоваров",
			"интернет магазин зоотоваров",
			"купить зоотовары в интернет магазине",
			"магазин зоотоваров барнаул",
			"зоотовары интернет магазин барнаул",
			"альф барнаул зоотовары",
		]);
		return $this->render('faq');
	}

	public
	function actionAbout()
	{
		Attributes::metaDescription("Небольшой рассказ о нашей компании, наших целях и планах на будущее");
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('about');
	}

	public function actionNews($id = null)
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

		if ($id) {

			$new = News::findBySlug($id);
			if ($new->slug) {
				Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $new->slug . "/");
			}

			if ($new->seo_description) {
				Attributes::metaDescription($new->seo_description);
			}

			if ($new->seo_keywords) {
				Attributes::metaKeywords($new->seo_keywords);
			}

			OpenGraph::title($new->title);
			OpenGraph::description(((!empty($new->preview)) ? $new->preview : $new->detail));
			OpenGraph::type("new");
			OpenGraph::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $new->slug . "/");

			if (!empty($new->preview_image)) {
				OpenGraph::image(sprintf('%s://%s/web/upload/%s', System::protocol(), $_SERVER['SERVER_NAME'], $new->preview_image));
			}

			return $this->render('detail/news', [
				'model' => $new
			]);
		}

		$categories = NewsCategory::find()->all();
		$news = News::find()->orderBy(['created_at' => SORT_DESC])->all();

//        Attributes::metaKeywords("уход за натуральной кожей, уход за сумкой из натуральной кожи,");
		Attributes::metaDescription("Самые полезные и актуальные статьи о том как ухаживать за кожей, как выбрать правильно продукт и другие новости компани!");

		return $this->render('news', [
			'news' => $news,
			'categories' => $categories
		]);
	}

	public
	function actionVacancy(
		$id = null
	) {
		Attributes::metaDescription("Здесь вы можете узнать о вакансиях нашей компании. Бывают момент, когда мы ищем новых людей в нашу команду");
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

		if ($id) {

			$model = Vacancy::findOne(['slug' => $id, 'city_id' => Yii::$app->session->get('city_id')]);

			if (!$model) {
				throw new HttpException(404, 'Вакансия не найдена.');
			}

			return $this->render('detail/vacancy', [
				'model' => $model
			]);
		}

		$items = Vacancy::find()->where(['city_id' => Yii::$app->session->get('city_id')])->all();
		return $this->render('vacancy', [
			'items' => $items
		]);
	}

	public
	function actionContacts()
	{
		Attributes::metaDescription("Контакты нашего интернет магазина");
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('contacts');
	}

	public
	function actionBrands(
		$id = null
	) {
		if ($id) {
			$model = InformersValues::findOne($id);
			return $this->render('detail/brands', [
				'model' => $model
			]);
		}
		return $this->render('brands');
	}

	public function actionCompare()
	{
		Attributes::metaDescription('Сравнение товаров в интернет магазине Котофей');
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('compare');
	}

	public function actionReferal()
	{
		return $this->render('referal');
	}

	public function actionRestore($id = null)
	{
		if ($id) {
			$userResetPasswordModel = UserResetPassword::findOne(['key' => $id]);
			$userResetPasswordForm = new PasswordRestoreForm(['scenario' => PasswordRestoreForm::SCENARIO_UPDATE_PASSWORD]);

			if ($userResetPasswordModel && $userResetPasswordModel->isAlive()) {
				if (\Yii::$app->request->isPost) {
					if ($userResetPasswordForm->load(\Yii::$app->request->post())) {
						if ($userResetPasswordForm->validate()) {
							if ($userResetPasswordForm->updatePassword($userResetPasswordModel->user_id)) {
								Alert::setSuccessNotify('Вы успешно сменили пароль и вошли в систему.');
								return $this->redirect('/');
							}
						}
					}
				}

				return $this->render('restore-form', [
					'model' => $userResetPasswordForm
				]);
			}
		}

		$model = new PasswordRestoreForm(['scenario' => PasswordRestoreForm::SCENARIO_SEND_MAIL]);
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->submit()) {
						Alert::setSuccessNotify("На ваш Email {$model->email} отправлены указания для восстановления.");
						return $this->redirect('/');
					}
				}
			}
		}

		return $this->render('restore', [
			'model' => $model
		]);
	}
}