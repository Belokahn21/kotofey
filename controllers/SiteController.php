<?

namespace app\controllers;

use app\models\entity\Basket;
use app\models\entity\Category;
use app\models\entity\Delivery;
use app\models\entity\Discount;
use app\models\entity\Favorite;
use app\models\entity\Order;
use app\models\entity\OrderItems;
use app\models\entity\News;
use app\models\entity\NewsCategory;
use app\models\entity\Payment;
use app\models\entity\Product;
use app\models\entity\Promo;
use app\models\entity\Providers;
use app\models\entity\SiteReviews;
use app\models\entity\support\SupportCategory;
use app\models\entity\support\SupportMessage;
use app\models\entity\support\Tickets;
use app\models\entity\user\Billing;
use app\models\forms\CatalogFilter;
use app\models\tool\Debug;
use app\models\tool\payments\Robokassa;
use app\models\tool\seo\Attributes;
use app\models\entity\User;
use app\models\tool\seo\og\OpenGraph;
use app\models\tool\System;
use app\models\tool\vk\entity\VKUser;
use app\models\tool\vk\VKWeb;
use app\widgets\notification\Notify;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Search;
use Yii;

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
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function beforeAction($action)
	{
		if (in_array($action->id, ['success', 'fail', 'test'])) {
			$this->enableCsrfValidation = false;
		}


//		if (System::isMobile() or Yii::$app->request->get('mobile') == "Y") {
//            $this->layout = "mobile";
//		}


		return parent::beforeAction($action);
	}

	public function actionIndex()
	{
		$providers = Providers::find()->where(['active' => true])->select(['name','description','link','image','sort','active'])->all();
		$news = News::find()->all();

		Attributes::metaDescription("Зоотовары онлайн с доставкой по Барнаулу и по всей России. Всегда свежие товары и по низкой цене!");
		Attributes::metaKeywords([
			"интернет магазин зоотоваров",
			"магазин зоотоваров барнаул",
			"интернет магазин зоотоваров барнаул",
			"сибагро барнаул зоотовары прайс",
			"товары для животных барнаул",
		]);

		return $this->render('index', [
			'providers' => $providers,
			'news'=>$news
		]);
	}

	public function actionSearch()
	{
		$model = new Search();

		if ($model->load(\Yii::$app->request->get())) {
			$products = $model->search();
		}

		return $this->render('search', [
			'model' => $model,
			'products' => $products
		]);
	}

	public function actionCatalog($id = null)
	{
		$filterModel = new CatalogFilter();
		$category = Category::findBySlug($id);
		if ($category) {
			$sb = $category->subsections();
		}
		if ($id) {
			$query = Product::find()->orderBy(['created_at' => SORT_DESC])->where([
				'category' => ArrayHelper::getColumn($sb, 'id')
			])->andWhere(['active' => 1]);
		} else {
			$query = Product::find()->orderBy(['created_at' => SORT_DESC])->andWhere(['active' => 1]);
		}

		$filterModel->applyFilter($query);
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
			$description = "Большой выбор аксессуаров ручной работы выполненых из натуральной кожи. В нашем магазине есть портмоне из натуральной кожи, обложки на паспорт ручной работы, кожаные картхолдеры, кожаный браслет для часов. Все эти товары есть в наличии и под заказ. Покупайте вместе с нами!";
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
		$product = Product::findBySlug($id);
		if (!$product instanceof Product) {
			throw new \yii\web\NotFoundHttpException("Товар не найден.");
		}


		$delivery = Delivery::find()->all();
		$payment = Payment::find()->all();
		$basket = new Basket();
		$order = new Order();

		$category = Category::findOne($product->category);
		$properties = \app\models\entity\ProductPropertiesValues::find()->where(['product_id' => $product->id])->all();

		if (!empty($product->seo_description)) {
			Attributes::metaDescription($product->seo_description);
		} else {
			Attributes::metaDescription($product->description);
		}

		if (!empty($product->seo_keywords)) {
			Attributes::metaKeywords($product->seo_keywords);
		}

		Attributes::canonical(System::protocol() . "://" . System::domain() . "/product/" . $product->slug . "/");


		OpenGraph::title($product->display);
		OpenGraph::description($product->description);
		OpenGraph::type("product");
		OpenGraph::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $product->slug . "/");

		if (!empty($product->image)) {
			OpenGraph::image(System::protocol() . "://" . System::domain() . $product->image);
		}


		return $this->render('product', [
			'product' => $product,
			'category' => $category,
			'properties' => $properties,

			'order' => $order,
			'delivery' => $delivery,
			'payment' => $payment,
			'basket' => $basket,
		]);
	}

	public function actionBasket()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/basket/");
		return $this->render('basket');
	}

	public function actionCheckout()
	{
		$delivery = Delivery::find()->all();
		$payment = Payment::find()->all();
		$basket = new Basket();

		if ($basket->isEmpty()) {
			return $this->redirect("/");
		}


		if (\Yii::$app->user->isGuest) {
			$order = new Order();
			$user = new User(['scenario' => User::SCENARIO_REGISTER_IN_CHECKOUT]);
			$billing = new Billing();
			$items = new OrderItems();

			// форма отправлена
			if (\Yii::$app->request->isPost) {
				$newUser = $user->createUser();
				if ($newUser instanceof User) {
					if ($newUser->login()) {
						$order->user = $newUser->id;

						/* @var $promo Promo */
						if ($promo = (new Basket())->getPromo()) {
							$order->promo_code = $promo->code;
						}


						if ($billing->load(\Yii::$app->request->post())) {
							$billing->user_id = $newUser->id;
							if ($billing->validate()) {
								if ($billing->save() === false) {
									return false;
								}
							}
						}

						if ($order->saveOrder()) {

							Promo::minusCode($order->promo_code);

							$items->orderId = $order->id;
							if ($items->saveItems()) {


								$robokassa = new Robokassa();
								$robokassa->config->setInvID($order->id);
								$robokassa->config->setDescription("Оплата товара");
								$robokassa->config->setSum($order->cash());

								$basket->clear();
								Promo::clear();

								$order->userNotify();
								$order->adminNotify();

								if ($_POST['type'] == 'paid') {
									return $this->redirect($robokassa->generateUrl());
								} else {
									Notify::setSuccessNotify("Заказ успешно создан!");
									return $this->redirect("/");
								}
							}
						}
					}
				}
			}

			return $this->render('checkout_guest', [
				'order' => $order,
				'user' => $user,
				'delivery' => $delivery,
				'payment' => $payment,
				'billing' => $billing,
			]);
		} else {
			$user = User::findOne(\Yii::$app->user->identity->id);
			$order = new Order();
			$items = new OrderItems();
			if (!$billing = Billing::findByUser(\Yii::$app->user->identity->id)) {
				$billing = new Billing();
			}

			if (\Yii::$app->request->isPost) {

				$order->user = \Yii::$app->user->identity->id;

				/* @var $promo Promo */
				if ($promo = (new Basket())->getPromo()) {
					$order->promo_code = $promo->code;
				}

				if ($billing->load(\Yii::$app->request->post())) {

					if (empty($billing->user_id)) {
						$billing->user_id = \Yii::$app->user->identity->id;

						if ($billing->validate()) {
							if ($billing->save() === false) {
								return false;
							}
						}

					} else {

						if ($billing->validate()) {
							if ($billing->update() === false) {
								return false;
							}

						}
					}
				}

				if ($order->saveOrder()) {

					Promo::minusCode($order->promo_code);

					$items->orderId = $order->id;
					if ($items->saveItems()) {

						$robokassa = new Robokassa();
						$robokassa->config->setInvID($order->id);
						$robokassa->config->setDescription("Оплата товара");
						$robokassa->config->setSum($order->cash());

						$basket->clear();
						Promo::clear();

						$order->userNotify();
						$order->adminNotify();

						if ($_POST['type'] == 'paid') {
							return $this->redirect($robokassa->generateUrl());
						} else {
							Notify::setSuccessNotify("Заказ успешно создан!");
							return $this->redirect("/");
						}
					}

				}
			}
			return $this->render('checkout_user', [
				'order' => $order,
				'delivery' => $delivery,
				'payment' => $payment,
				'billing' => $billing,
				'user' => $user,
			]);
		}
	}

	public function actionResult()
	{
		Debug::printFile($_POST);
		$orderId = $_POST['InvId'];
		$summPaid = $_POST['out_summ'];

		if ($orderId) {
			$order = Order::findOne($orderId);
			$order->paid = true;
			if ($order->update()) {

				$discount = Discount::findByUserId($order->user);
				if ($discount instanceof Discount) {
					if (!$discount->addDiscountForOrder()) {
						Notify::setErrorNotify("Ошибка при начислении бонусов. Обратитесь к администратору");
					}
				}
			}

			// Учёт товара
			$items = OrderItems::find()->where(['orderId' => $orderId])->all();
			foreach ($items as $item) {
				$product = Product::findOne($item->productId);

				if ($product->vitrine === true) {
					continue;
				}

				$product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
				if ($product) {
					if ($product->vitrine == 0 && $product->count > 0) {
						$product->count = $product->count - $item->count;
						if ($product->update() === false) {
							Notify::setErrorNotify("Проблема складского учёта");
						}
					}
				}
			}

			Notify::setSuccessNotify("Оплата по заказу №" . $orderId . " успешно внесена!");

			$order->adminNotifyAboutOrderPaid($summPaid);
		}
	}

	public function actionSuccess($id = null)
	{
		$orderId = $_POST['InvId'];
		$summPaid = $_POST['out_summ'];
		if (empty($orderId)) {
			$orderId = $id;
		}
		if ($orderId) {
			$order = Order::findOne($orderId);
			$order->paid = true;
			if ($order->update()) {

				$discount = Discount::findByUserId($order->user);
				if ($discount instanceof Discount) {
					if (!$discount->addDiscountForOrder()) {
						Notify::setErrorNotify("Ошибка при начислении бонусов. Обратитесь к администратору");
					}
				}
			}

			// Учёт товара
			$items = OrderItems::find()->where(['orderId' => $orderId])->all();
			foreach ($items as $item) {
				$product = Product::findOne($item->productId);

				if ($product->vitrine === true) {
					continue;
				}

				$product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
				if ($product) {
					if ($product->vitrine == 0 && $product->count > 0) {
						$product->count = $product->count - $item->count;
						if ($product->update() === false) {
							Notify::setErrorNotify("Проблема складского учёта");
						}
					}
				}
			}

			Notify::setSuccessNotify("Оплата по заказу №" . $orderId . " успешно внесена!");

			$order->adminNotifyAboutOrderPaid($summPaid);


			return $this->redirect("/");
		} else {
			Notify::setErrorNotify("Ошибка при внесении оплаты на сайте. Обратитесь к администратору");
			return $this->redirect("/");
		}
	}

	public function actionFail()
	{
		return $this->redirect("/");
	}

	public function actionProfile($id = null)
	{
		if ($id) {
			$user = User::findOne($id);
			return $this->render('detail/profile', [
				'user' => $user
			]);
		} else {
			$userId = \Yii::$app->user->identity->id;
			$favorite = (new Favorite())->listProducts();
			$profile = User::findOne($userId);
			$profile->scenario = User::SCENARIO_USER_UPDATE;
			Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

			if (\Yii::$app->request->isPost) {
				if ($profile->load(\Yii::$app->request->post())) {
					if ($profile->validate()) {
						if ($profile->uploadAvatar()) {
							if ($profile->update()) {
								Notify::setSuccessNotify("Профиль успешно обновлен");
								return $this->refresh();
							}
						}
					}
				}
			}

			return $this->render('profile', [
				'profile' => $profile,
				'favorite' => $favorite,
			]);
		}
	}

	public function actionSignin()
	{
		$model = new User(['scenario' => User::SCENARIO_LOGIN]);
		$vkweb = new VKWeb();
		$vkweb->setRedirectUri("https://eventhorizont.ru/signin/");

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->login()) {
					Notify::setSuccessNotify("Вы успешно авторизовались!");
					return $this->redirect("/");
				}
			}
		}

		if (isset($_GET['code'])) {
			$vkuser = $vkweb->getVKUser();
			if ($vkuser) {
				$model->vk_uid = $vkuser->id;
				if ($model->loginVk()) {
					Notify::setSuccessNotify("Вы успешно авторизовались!");
					return $this->redirect("/");
				} else {
					Notify::setWarningNotify("Пользователь не найден!");
					return $this->redirect("/signin/");
				}
			}
		}

		return $this->render('auth/signin', [
			'model' => $model,
			'vkweb' => $vkweb,
		]);
	}

	public function actionSignup()
	{
		$model = new User(['scenario' => User::SCENARIO_REGISTER]);
		$vkweb = new VKWeb();
		$vkweb->setRedirectUri("https://eventhorizont.ru/signup/");

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {

				if ($_SESSION['STORAGE']['vkuser']) {

					$model->vk_uid = $_SESSION['STORAGE']['vkuser']->id;
					VKUser::deleteFromSession();
				}

				if ($model->createUser()) {
					if ($model->login()) {

						Notify::setSuccessNotify("Успешная регистрация!");
						return $this->redirect("/");
					}
				}
			}
		}

		if (isset($_GET['code'])) {
			$vkuser = $vkweb->getVKUser();
			if ($vkuser) {
				$vkuser->saveToSession();
				return $this->render('auth/vk_signup', [
					'model' => $model,
					'vkweb' => $vkweb,
					'vkuser' => $vkuser,
				]);
			} else {
				VKUser::deleteFromSession();
			}
		}

		return $this->render('auth/signup', [
			'model' => $model,
			'vkweb' => $vkweb,
		]);
	}

	public function actionPayment()
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

	public function actionDelivery()
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

	public function actionLogout()
	{
		\Yii::$app->user->logout();
		return $this->redirect('/');
	}

	public function actionOrder($id = null)
	{
		try {
			$orders = Order::findByFilter(\Yii::$app->request->get());
		} catch (\Exception $exception) {
			$orders = Order::findAll(['user' => \Yii::$app->user->identity->id]);
		}

		if ($id) {
			$order = Order::findOne($id);

			if (empty($order)) {
				throw new \Exception("Такого заказа не существует");
			}

			if (!$order->hasAccess()) {
				throw new \Exception("Доступ к чужому заказу запрещён");
			}

			$items = OrderItems::findAll(['orderId' => $order->id]);

			return $this->render('detail/order', [
				'order' => $order,
				'items' => $items,
			]);
		} else {
			return $this->render('order', [
				'orders' => $orders
			]);
		}
	}

	public function actionSupport($category = null, $id = null)
	{
		if (empty($category) && empty($id)) {   // list categories
			$categories = SupportCategory::find()->all();
			$tickets = Tickets::find()->where(['user_id' => \Yii::$app->user->identity->id])->all();
			$model = new Tickets();
			Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->save()) {
							Notify::setSuccessNotify("Обращение создано!");
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('support/categories', [
				'categories' => $categories,
				'tickets' => $tickets,
				'model' => $model,
			]);
		}

		if (empty($category) && !empty($id)) {  // list tickets

			$model = new Tickets();
			$category = SupportCategory::findOne($id);
			if (User::isRole('Support')) {
				$tickets = Tickets::findAll(['category_id' => $id]);
			} else {
				$tickets = Tickets::findAll(['user_id' => \Yii::$app->user->identity->id, 'category_id' => $id]);
			}

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {

					$model->category_id = $id;

					if ($model->validate()) {
						if ($model->save()) {
							Notify::setSuccessNotify("Обращение создано!");
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('support/new_ticket', [
				'model' => $model,
				'tickets' => $tickets,
				'category' => $category
			]);
		}

		if (!empty($category) && !empty($id)) { //detail
			$ticket = Tickets::findOne($id);
			$model = new SupportMessage();
			$messages = SupportMessage::find()->where(['ticket_id' => $id])->orderBy(['created_at' => SORT_ASC])->all();

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {

					$model->ticket_id = $id;

					if ($model->validate()) {
						if ($model->save()) {
							Notify::setSuccessNotify("Сообщение отправлено!");
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('support/detail', [
				'ticket' => $ticket,
				'model' => $model,
				'messages' => $messages,
			]);
		}
	}

	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception]);
		}
	}

	public function actionTest()
	{
		return $this->render('test');
	}

	public function actionClear()
	{
		Basket::clear();
		Promo::clear();
		Notify::setSuccessNotify("Корзина очищена!");
		return $this->redirect('/');
	}

	public function actionFavorite()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		$products = Favorite::listProducts();
		return $this->render('favorite', [
			'products' => $products
		]);
	}

	public function actionReviews()
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		Attributes::metaDescription("Узнайте, что думают о нас клиенты и простые пользователи сайта. Мы рады новым отзывам о нашей работе. Для клиентов оставивших отзыв за покупку мы дарим скидку на последующие покупки");
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
		$reviews = SiteReviews::find()->all();
		$model = new SiteReviews();
		if ($user = User::findOne(\Yii::$app->user->identity->id)) {
			$user->scenario = User::SCENARIO_NEW_REVIEW;
		} else {
			$user = new User(['scenario' => User::SCENARIO_NEW_REVIEW]);
		}

		if (\Yii::$app->request->isPost) {
			if ($user->load(\Yii::$app->request->post())) {
				if ($user->validate()) {
					if ($user->update() !== false) {
						if ($model->create()) {
							Notify::setSuccessNotify("Отзыв успешно добавлен!");
							return $this->refresh();
						}
					}
				}
			}
		}
		return $this->render('reviews', [
			'reviews' => $reviews,
			'model' => $model,
			'user' => $user,
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

	public function actionBuy()
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
		return $this->render('buy');
	}

	public function actionAbout()
	{
		Attributes::metaDescription("Небольшой рассказ о нашей компании, наших целях и планах на будущее");
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('about');
	}

	public function actionNews($id = null)
	{
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");

		if ($id) {

			$article = News::findBySlug($id);
			if ($article->slug) {
				Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $article->slug . "/");
			}

			if ($article->seo_description) {
				Attributes::metaDescription($article->seo_description);
			}

			if ($article->seo_keywords) {
				Attributes::metaKeywords($article->seo_keywords);
			}

			OpenGraph::title($article->title);
			OpenGraph::description(((!empty($article->preview)) ? $article->preview : $article->detail));
			OpenGraph::type("article");
			OpenGraph::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $article->slug . "/");

			if (!empty($article->preview_image)) {
				OpenGraph::image($article->preview_image);
			}

			return $this->render('detail/articles', [
				'article' => $article
			]);
		}

		$categories = NewsCategory::find()->all();
		$pages = News::find()->all();

//        Attributes::metaKeywords("уход за натуральной кожей, уход за сумкой из натуральной кожи,");
		Attributes::metaDescription("Самые полезные и актуальные статьи о том как ухаживать за кожей, как выбрать правильно продукт и другие новости компани!");

		return $this->render('articles', [
			'news' => $pages
		]);
	}

	public function actionVacancy()
	{
		Attributes::metaDescription("Здесь вы можете узнать о вакансиях нашей компании. Бывают момент, когда мы ищем новых людей в нашу команду");
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('vacancy');
	}

	public function actionContacts()
	{
		Attributes::metaDescription("Контакты нашего интернет магазина");
		Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
		return $this->render('contacts');
	}
}