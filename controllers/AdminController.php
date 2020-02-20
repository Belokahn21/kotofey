<?php

namespace app\controllers;

use app\models\entity\Category;
use app\models\entity\Delivery;
use app\models\entity\Geo;
use app\models\entity\GeoTimezone;
use app\models\entity\Informers;
use app\models\entity\InformersValues;
use app\models\entity\News;
use app\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\OrderStatus;
use app\models\entity\NewsCategory;
use app\models\entity\Payment;
use app\models\entity\ProductMarket;
use app\models\entity\ProductOrder;
use app\models\entity\ProductProperties;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\Promo;
use app\models\entity\Providers;
use app\models\entity\Search;
use app\models\entity\SearchQuery;
use app\models\entity\Selling;
use app\models\entity\ShortLinks;
use app\models\entity\SiteSettings;
use app\models\entity\Sliders;
use app\models\entity\SlidersImages;
use app\models\entity\Stocks;
use app\models\entity\support\SupportCategory;
use app\models\entity\support\SupportStatus;
use app\models\entity\support\Tickets;
use app\models\entity\User;
use app\models\entity\UserManager;
use app\models\entity\UserSeller;
use app\models\entity\UserManagerScore;
use app\models\entity\Vacancy;
use app\models\entity\Vendor;
use app\models\entity\VendorGroup;
use app\models\forms\FeedmakerForm;
use app\models\helpers\OrderHelper;
use app\models\helpers\PersonalHelper;
use app\models\rbac\AuthAssignment;
use app\models\rbac\AuthItem;
use app\models\search\AuthItemSearchForm;
use app\models\search\CategorySearchForm;
use app\models\search\DeliverySearchForm;
use app\models\search\GeoSearchForm;
use app\models\search\GeoTimezoneSearch;
use app\models\search\InformersSearchForm;
use app\models\search\InformersValuesSearchForm;
use app\models\search\NewsSearchForm;
use app\models\search\NewsCategorySearchForm;
use app\models\search\OrderSearchForm;
use app\models\search\OrderStatusSearchForm;
use app\models\search\PermissionsSearchForm;
use app\models\search\ProductPropertiesSearchForm;
use app\models\search\ProductSearchForm;
use app\models\search\PromocodeSearchForm;
use app\models\search\TicketSearchForm;
use app\models\search\VendorGroupSearchForm;
use app\models\search\VendorSearchForm;
use app\models\search\SettingsSearchForm;
use app\models\search\ShortLinksSearchModel;
use app\models\search\SlidersImagesSearchForm;
use app\models\search\SlidersSearchForm;
use app\models\search\StockSearchForm;
use app\models\search\UserSearchForm;
use app\models\search\VacancySearchForm;
use app\models\tool\Backup;
use app\models\tool\Debug;
use app\models\tool\export\YandexCatalogExport;
use app\models\tool\export\YMLExport;
use app\models\tool\statistic\OrderStatistic;
use app\widgets\notification\Alert;
use Codeception\Lib\Di;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx\Styles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\i18n\MessageFormatter;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;
use Yii;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class AdminController extends Controller
{
	public $layout = "admin";

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['Administrator', 'Developer'],
					],
					[
						'allow' => false,
						'roles' => ['?'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
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

	public function actionIndex()
	{
		$last_search = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();

		if (Yii::$app->request->get('save_dump') == 'Y') {
			$backup = new Backup();
			if ($backup->isOverSize()) {
				$backup->clearDumpCatalog();
			}
			$backup->createDumpDatabase();

			return $this->redirect(['admin/index']);
		}

		return $this->render('index', [
			'last_search' => $last_search
		]);
	}

	public function actionCatalog($id = null)
	{
		// удалить товар
		if (Yii::$app->request->get('action') == 'delete') {
			$item = Product::findOne($id);

			$item->removeOldImages();   // удалить галерею

			if ($item->delete()) {
				Alert::setSuccessNotify('Продукт удален');
				return $this->redirect('/admin/catalog/');
			}
		}

		// экспорт
		if (isset($_GET['export']) && !empty($_GET['export'])) {
			switch ($_GET['export']) {
				case "yml":
					$ymlExport = new YMLExport();
					$ymlExport->create();
					break;
				case "yandex":
					$yandexCatalog = new YandexCatalogExport();
					$yandexCatalog->create();
					break;
			}
		}

		if ($id == null) {
			$model = new Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
			$modelDelivery = new ProductOrder();
			$searchModel = new ProductSearchForm();
			$dataProvider = $searchModel->search(\Yii::$app->request->get());
			$properties = ProductProperties::find()->all();

			if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return ActiveForm::validate($model);
			}

			if ($model->createProduct()) {
				Alert::setSuccessNotify('Продукт создан');
				return $this->refresh();
			}

			return $this->render('catalog', [
				'model' => $model,
				'modelDelivery' => $modelDelivery,
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'properties' => $properties,
			]);
		}

		$model = Product::findOne($id);
		$model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
		if (ProductMarket::hasStored($model->id)) {
			$model->has_store = true;
		}
		$properties = ProductProperties::find()->all();
		if (!$modelDelivery = ProductOrder::findOneByProductId($model->id)) {
			$modelDelivery = new ProductOrder();
		}

		if (Yii::$app->request->get('action') == 'copy') {
			if (Yii::$app->request->post('action') == 'Копировать') {
				$model->id = null;
				$model->article = null;
				$model->isNewRecord = true;
				$model->scenario = Product::SCENARIO_NEW_PRODUCT;
				if ($model->createProduct()) {
					Alert::setSuccessNotify('Продукт скопирован');
					return $this->redirect('/admin/catalog/');
				}
			}

		}

		if ($model->updateProduct()) {
			Alert::setSuccessNotify('Продукт обновлен');
			return $this->refresh();
		}

		return $this->render('detail/catalog', [
			'model' => $model,
			'modelDelivery' => $modelDelivery,
			'properties' => $properties,
		]);
	}

	public function actionCategory($id = null)
	{

		// удалить раздел
		if (Yii::$app->request->get('action') == 'delete') {
			$item = Category::findOne($id);
			if ($item->delete()) {
				Alert::setSuccessNotify('Раздел удален');
				return $this->redirect('admin/category');
			}
		}


		if ($id) {
			$model = Category::findOne($id);
			if (!$model) {
				throw new HttpException(404, 'Раздел товара не существует');
			}

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->save()) {
							Alert::setSuccessNotify('Категория обновлена');
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/category', [
				'model' => $model,
				'categories' => $model->categoryTree(),
			]);
		}

		$model = new Category();
		$searchForm = new CategorySearchForm();
		$dataProvider = $searchForm->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Категория создана');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('category', [
			'model' => $model,
			'searchForm' => $searchForm,
			'categories' => $model->categoryTree(),
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionOrder($id = null)
	{
		if (Yii::$app->request->get('id') && Yii::$app->request->get('action') && Yii::$app->request->get('action') == 'delete') {
			$order = Order::findOne((int)Yii::$app->request->get('id'));
			if ($order) {
				$order->delete();
			}
			return $this->redirect('/admin/order/');
		}

		if ($id) {
			$order = Order::findOne($id);
			$order->scenario = Order::SCENARIO_CUSTOM;
			$itemModel = new OrdersItems();
			$items = OrdersItems::find()->where(['order_id' => $id])->all();
			if (!$order) {
				throw new HttpException(404, 'Заказ не найден');
			}

			if (Yii::$app->request->isPost) {
				if ($order->load(Yii::$app->request->post())) {
					if ($order->update()) {

						if (!$items) {
							foreach (Yii::$app->request->post('OrdersItems', []) as $model) {
								$items[] = new OrdersItems();
							}
						}

						if (OrdersItems::loadMultiple($items, Yii::$app->request->post())) {
							foreach ($items as $item) {

								if (empty($item->product_id)) {
									continue;
								}

								if ($item->need_delete) {
									$item->delete();
									continue;
								}

								if ($item->validate()) {
									if ($item->save() !== true) {
										Alert::setErrorNotify('Заказ не обновлён. Ошибка при сохранении товаров');
										return $this->refresh();
									}
								}
							}
						}


						Alert::setSuccessNotify('Заказ успешно обновлён');
						return $this->refresh();
					}
				}


			}

			return $this->render('detail/order', [
				'model' => $order,
				'items' => $items,
				'itemModel' => $itemModel
			]);
		}

		$model = new Order();
		$model->scenario = Order::SCENARIO_CUSTOM;
		$searchModel = new OrderSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());
		$itemModel = new OrdersItems();

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Заказ успешно создан');
						return $this->refresh();
					}

				}
			}
		}


		return $this->render('order', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'model' => $model,
			'itemModel' => $itemModel,
		]);
	}

	public function actionUser($id = null)
	{
		$model = new User(['scenario' => User::SCENARIO_INSERT]);
		$authAssigment = new AuthAssignment();
		$searchModel = new UserSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());
		$groups = AuthItem::find()->where(['type' => AuthItem::TYPE_ROLE])->all();

		// авторизоваться
		if (!empty($_GET['id']) && !empty($_GET['action']) && $_GET['action'] == 'auth') {
			$user = User::findOne(Yii::$app->request->get('id'));
			if ($user) {
				if (Yii::$app->user->login($user)) {
					return $this->redirect('/admin/user/');
				}
			}
		}
		// удалить юзера
		if (!empty($_GET['id']) && !empty($_GET['action']) && $_GET['action'] == 'delete') {
			$user = User::findOne($id);

			if ($user->delete()) {
				return $this->redirect('/admin/user/');
			}
		}

		// детальный юзер
		if ($id) {
			$model = User::findOne($id);
			$model->scenario = User::SCENARIO_UPDATE;

			// обновить юзера
			if (\Yii::$app->request->isPost) {

				if ($model->load(\Yii::$app->request->post())) {

					if ($model->validate()) {

						if (!empty($model->new_password)) {
							$model->setPassword($model->new_password);
						}


						if ($model->groups) {
							$authAssigment->removeUserRoles($model->id);
							$authAssigment->addUserRole($model->groups, $model);
						}

						if ($model->update() !== false) {
							Alert::setSuccessNotify("Информация о пользователе успешно обновлена");
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/user', [
				'model' => $model,
				'groups' => $groups,
			]);
		}

		// сохранить юзера
		if (\Yii::$app->request->isPost) {

			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					$model->setPassword($model->password);
					$model->generateAuthKey();
					$transaction = Yii::$app->db->transaction;
					$transaction->begin();

					if ($model->save()) {

						if (!empty($model->group)) {
							$authAssigment->addUserRole(AuthItem::findOne(['name' => $model->group]), $model);
						}

						Alert::setSuccessNotify('Пользователь успешно создан');
						$transaction->commit();
						return $this->refresh();
					}
				}
			}
			return $this->refresh();
		}

		return $this->render('user', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'groups' => $groups,
		]);
	}

	public function actionGroup($id = null)
	{
		if (Yii::$app->request->get('action') == 'delete' && Yii::$app->request->get('id')) {
			$db = \Yii::$app->db;
			$transaction = $db->beginTransaction();
			if (!Yii::$app->authManager->remove(Yii::$app->authManager->getRole(Yii::$app->request->get('id')))) {
				$transaction->rollBack();
			}
			$transaction->commit();
			Alert::setSuccessNotify('Группа успешно удалена');
			return $this->redirect('/admin/group/');
		}

		if ($id) {

			$model = AuthItem::findOne(['name' => $id]);

			if (!$model) {
				throw new HttpException(404, 'Группа не найдена');
			}


			return $this->render('detail/group', [
				'model' => $model
			]);
		}

		$model = new AuthItem();
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->createRole()) {
						return $this->refresh();
					}
				}
			}
		}
		$searchModel = new AuthItemSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());
		return $this->render('group', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,

		]);
	}

	public
	function actionPermission()
	{
		$model = new AuthItem();
		$searchModel = new PermissionsSearchForm();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->createPermission()) {
						return $this->refresh();
					}
				}
			}
		}
		return $this->render('permission', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel
		]);
	}

	public
	function actionDelivery(
		$id = null
	) {
		if ($id) {
			$model = Delivery::findOne($id);
			if (!$model) {
				throw new HttpException(404, 'Доставка не существует');
			}

			if (\Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Доставка обновлена');
							return $this->refresh();
						}
					}
				}
			}
			return $this->render('detail/delivery', [
				'model' => $model
			]);
		}

		$model = new Delivery();
		$searchModel = new DeliverySearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Доставка создана');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('delivery', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionPayment(
		$id = null
	) {

		if ($id) {
			$model = Payment::findOne($id);
			if (!$model) {
				throw new HttpException(404, 'Оплата не существует');
			}


			if (\Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Ооплата обновлена');
							return $this->refresh();
						}
					}
				}
			}
			return $this->render('detail/payment', [
				'model' => $model
			]);
		}

		$model = new Payment();
		$dataProvider = $model->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Ооплата добавлена');
						return $this->refresh();
					}
				}
			}
		}


		return $this->render('payment', [
			'model' => $model,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionStatus($id = null)
	{
		if ($id) {
			$model = OrderStatus::findOne($id);
			if (!$model) {
				throw new HttpException(404, 'Статус не существует');
			}
			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Статус обновлен');
							return $this->refresh();
						}
					}
				}
			}
			return $this->render('detail/status', [
				'model' => $model
			]);
		}
		$model = new OrderStatus();
		$searchModel = new OrderStatusSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Статус добавлен');
						return $this->refresh();
					}
				}
			}
		}


		return $this->render('status', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	public
	function actionSupport(
		$id = null
	) {
		$model = new Tickets();
		$searchModel = new TicketSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		return $this->render('support', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	public
	function actionSupportCategory(
		$id = null
	) {
		$model = new SupportCategory();

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Раздел тех. поддержки создан');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('supportcategory', [
			'model' => $model
		]);
	}

	public
	function actionSupportstatus(
		$id = null
	) {
		$model = new SupportStatus();

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('supportstatus', [
			'model' => $model
		]);
	}

	public
	function actionSettings(
		$id = null
	) {
		// Удалить
		if ($id && !empty($_GET['action']) && $_GET['action'] == "delete") {
			$element = SiteSettings::findOne($id);

			if ($element->type == 'file') {
				unlink(Yii::getAlias('@app') . $element->value);
			}

			if ($element->delete()) {
				return $this->redirect('/admin/settings/');
			}
		}

		$model = new SiteSettings();
		if ($id) {
			$model = SiteSettings::findOne($id);

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify("Настройки обновлены");
							return $this->redirect('/admin/settings/' . $id . '/');
						}
					}
				}
			}

			return $this->render('detail/settings', [
				'model' => $model,
			]);

		}

		if ($id == null) {
			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {

					if (Yii::$app->request->get('type') == 'file') {
						$model->file = UploadedFile::getInstance($model, 'file');

						if (!empty($model->file)) {
							$fileName = substr(md5($model->file->baseName), 0, 32) . ' . ' . $model->file->extension;
							$path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;

							$model->file->saveAs($path);
							$model->value = "/web/upload/" . $fileName;
						}
					}

					if ($model->validate()) {
						if ($model->save()) {
							Alert::setSuccessNotify("Настройки сохранены");
							return $this->redirect('/admin/settings/');
						}
					}
				}
			}
		}

		$searchModel = new SettingsSearchForm();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('settings', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionProperties(
		$id = null
	) {

		if ($id) {
			$model = ProductProperties::findOne($id);

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							return $this->refresh();
						}
					}
				}
			}

			return $this->render("detail/properties", [
				'model' => $model,
			]);
		}

		$model = new ProductProperties();
		$searchModel = new ProductPropertiesSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}

		return $this->render("properties", [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionNews(
		$id = null
	) {
		// Удалить
		if ($id && !empty($_GET['action']) && $_GET['action'] == "delete") {
			$article = News::findOne($id);

			if ($article->delete()) {
				return $this->redirect('/admin/news/');
			}
		}

		if ($id) {
			$model = News::findOne($id);
			$model->scenario = News::SCENARIO_UPDATE;

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {

						if ($model->update()) {
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/news', [
				'model' => $model,
			]);
		}

		$model = new News(['scenario' => News::SCENARIO_INSERT]);
		$searchModel = new NewsSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {

					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('news', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionStocks(
		$id = null
	) {
		if ($id) {
			$model = Stocks::findOne($id);
			if (Yii::$app->request->isPost) {
				if ($model->edit()) {
					Alert::setSuccessNotify('Склад успешно обновлен');
					return $this->refresh();
				}
			}
			return $this->render('detail/stocks', [
				'model' => $model,
			]);
		}

		$model = new Stocks();
		$searchModel = new StockSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (Yii::$app->request->isPost) {
			if ($model->create()) {
				Alert::setSuccessNotify('Склад успешно создан');
				return $this->refresh();
			}
		}

		return $this->render('stocks', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionNewssections(
		$id = null
	) {
		if ($id) {
			$model = NewsCategory::findOne($id);
			if (!$model) {
				throw new HttpException(404, 'Запись не найдена');
			}

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Рубрика обновлена');
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/news-category', [
				'model' => $model,
			]);
		}

		$model = new NewsCategory();
		$searchModel = new NewsCategorySearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Рубрика создана');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('news-category', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionInformers(
		$id = null
	) {
		if ($id) {
			$model = Informers::findOne($id);
			if (\Yii::$app->request->isPost) {

				if ($model->load(\Yii::$app->request->post())) {

					if ($model->validate()) {

						if ($model->update()) {
							return $this->refresh();
						}
					}
				}
			}


			return $this->render('detail/informers', [
				'model' => $model
			]);
		}

		$model = new Informers();
		$searchModel = new InformersSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {

			if ($model->load(\Yii::$app->request->post())) {

				if ($model->validate()) {

					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('informers', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionInformersValues(
		$id = null
	) {

		if (Yii::$app->request->get('action') == 'delete') {
			$obj = InformersValues::findOne($id);
			if ($obj) {
				$obj->delete();
			}
			return $this->redirect('/admin/informersvalues/');
		}

		if ($id) {
			$model = InformersValues::findOne($id);
			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Значение справочника обновлено');
							return $this->refresh();
						}
					}
				}
			}


			return $this->render('detail/informersvalues', [
				'model' => $model,
			]);
		}

		$model = new InformersValues();
		$searchModel = new InformersValuesSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Значение справочника добавлено');
						return $this->refresh();
					}
				} else {
					Alert::setErrorNotify(Debug::modelErrors($model));
				}
			}
		}

		return $this->render('informersvalues', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionSelling(
		$id = null
	) {

		$model = new Selling();
		return $this->render('selling', [
			'model' => $model
		]);
	}

	public
	function actionPromo(
		$id = null
	) {

		if ($id) {
			$promo = Promo::findOne($id);

			if (Yii::$app->request->isPost) {
				if ($promo->load(Yii::$app->request->post())) {
					if ($promo->validate()) {
						if ($promo->update()) {
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/promo', [
				'model' => $promo
			]);
		}

		$model = new Promo();
		$searchModel = new PromocodeSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());
		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}
		return $this->render('promo', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionVendor(
		$id = null
	) {
		if (Yii::$app->request->get('action') == 'delete') {
			if (!Vendor::findOne($id)->delete()) {
				throw new HttpException(404, 'Запись не найдена');
			}
		}

		if ($id) {
			$model = Vendor::findOne($id);
			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->update()) {
						return $this->refresh();
					}
				}
			}
			return $this->render('detail/vendor', [
				'model' => $model
			]);
		}

		$model = new Vendor();
		$searchModel = new VendorSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->save()) {
					return $this->refresh();
				}
			}
		}

		return $this->render('vendor', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionVendorGroup(
		$id = null
	) {
		if (Yii::$app->request->get('action') == 'delete') {
			if (!VendorGroup::findOne($id)->delete()) {
				throw new HttpException(404, 'Запись не найдена');
			}
		}

		if ($id) {
			$model = VendorGroup::findOne($id);
			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->update()) {
						return $this->refresh();
					}
				}
			}
			return $this->render('detail/vendor-group', [
				'model' => $model
			]);
		}

		$model = new VendorGroup();
		$searchModel = new VendorGroupSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						return $this->refresh();
					} else {
						exit(1);
					}
				} else {
					exit(2);
				}
			}
		}

		return $this->render('vendor-group', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionSliders(
		$id = null
	) {
		if ($id) {
			$model = Sliders::findOne($id);
			$model->scenario = Providers::SCENARIO_UPDATE;
			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->update()) {
						return $this->refresh();
					}
				}
			}
			return $this->render('detail/sliders', [
				'model' => $model
			]);
		}

		$model = new Sliders();
		$searchModel = new SlidersSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->save()) {
					return $this->refresh();
				}
			}
		}

		return $this->render('sliders', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionSliderimages(
		$id = null
	) {
		if ($id) {
			$model = SlidersImages::findOne($id);
			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->update()) {
						Alert::setSuccessNotify('Изображение обновлено');
						return $this->refresh();
					}
				}
			}
			return $this->render('detail/sliders_images', [
				'model' => $model
			]);
		}

		$model = new SlidersImages();
		$searchModel = new SlidersImagesSearchForm();
		$dataProvider = $searchModel->search(\Yii::$app->request->get());

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->save()) {
					Alert::setSuccessNotify('Изображение к слайду добавлено');
					return $this->refresh();
				}
			}
		}

		return $this->render('sliders_images', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionGeo(
		$id = null
	) {
		$time_zones = GeoTimezone::find()->all();
		if ($id) {
			$model = Geo::findOne($id);
			if (!$model) {
				throw new HttpException(404, 'Гео объект не найден');
			}
			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Гео объект обновлен');
							return $this->refresh();
						}
					}
				}
			}
			return $this->render('detail/geo', [
				'model' => $model,
				'time_zones' => $time_zones,
			]);
		}

		$model = new Geo();
		$searchModel = new GeoSearchForm();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Гео объект добавлен');
						return $this->refresh();
					}
				}
			}
		}
		return $this->render('geo', [
			'model' => $model,
			'time_zones' => $time_zones,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}

	public
	function actionTimezone(
		$id = null
	) {
		if ($id) {
			$model = GeoTimezone::findOne($id);

			if (!$model) {
				throw new HttpException(404, 'Элемент не найден');
			}


			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Временая зона успешно обновлена');
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/timezone', [
				'model' => $model
			]);
		}

		$model = new GeoTimezone();
		$searchModel = new GeoTimezoneSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Временая зона успешно добвлена');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('timezone', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	public
	function actionFeed()
	{
		$products = array();
		$model = new FeedmakerForm();
		$property_values = InformersValues::find()->where(['informer_id' => 1])->orderBy(['name' => SORT_ASC])->all();

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {

					$search = new Search();
					$search->search = $model->name;
					$products = $search->search();

					if ($products && !empty($model->feed)) {
						foreach ($products as $product) {
							$product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

							if ($model->update) {
								$product->feed = $model->feed;
							} else {
								$product->feed .= $model->feed;
							}

							if ($product->validate()) {
								if ($product->update() == false) {
									Alert::setErrorNotify(Debug::modelErrors($model));
									return $this->refresh();
								}
							}
						}
					}
				}
			}
		}
		return $this->render('feed', [
			'model' => $model,
			'products' => $products,
		]);
	}

	public
	function actionShortly(
		$id = null
	) {
		if ($id) {
			$model = ShortLinks::findOne($id);

			if (!$model) {
				throw new HttpException(404, 'Запись не найдена');
			}


			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->update()) {
							Alert::setSuccessNotify('Короткая ссылка успешно обновлена');
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/shortly', [
				'model' => $model
			]);
		}

		$model = new ShortLinks();
		$searchModel = new ShortLinksSearchModel();
		$dataProvider = $searchModel->search(Yii::$app->request->get());


		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Короткая ссылка успешно добавлена');
						return $this->refresh();
					}
				}
			}
		}


		return $this->render('shortly', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public
	function actionManagement()
	{
		return $this->render('management');
	}

	public
	function actionVacancy(
		$id = null
	) {
		$city_list = Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->all();


		if ($id) {
			$model = Vacancy::findOne($id);

			if (!$model) {
				throw new HttpException(404, 'Элемент не найден');
			}

			if (\Yii::$app->request->isPost) {
				if ($model->load(\Yii::$app->request->post())) {
					if ($model->validate()) {
						if ($model->save()) {
							Alert::setSuccessNotify('Вакансия успешно обновлена');
							return $this->refresh();
						}
					}
				}
			}

			return $this->render('detail/vacancy', [
				'model' => $model,
				'city_list' => $city_list
			]);
		}
		$model = new Vacancy();
		$searchModel = new VacancySearchForm();
		$dataProvider = $searchModel->search(Yii::$app->request->get());

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						Alert::setSuccessNotify('Вакансия успешно добавлена');
						return $this->refresh();
					}
				}
			}
		}

		return $this->render('vacancy', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'city_list' => $city_list
		]);
	}

	public
	function actionCache()
	{
		Yii::$app->cache->flush();
		return $this->redirect('/');
	}

	public function actionPersonal()
	{
		return $this->render('personal');
	}

	public function actionOrderReport($id)
	{
		$order = Order::findOne($id);
		if (!$order) {
			throw new HttpException(404, 'Запись не найдена');
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$file_name = "order_{$order->id}.xlsx";

		// Размеры колонок
		$sheet->getColumnDimension('A')->setWidth('12');
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setWidth('10');
		$sheet->getColumnDimension('D')->setWidth('12');
		$sheet->getColumnDimension('E')->setWidth('6');
		$sheet->getColumnDimension('F')->setWidth('8');
		$sheet->getColumnDimension('G')->setWidth('8');

		// Заголовок
		$sheet->setCellValue('A1', sprintf('Товарная наклданая №%s от %s', $order->id, date('d.m.Y', $order->created_at)));
		$sheet->mergeCells('A1:G1');
		$sheet->getStyle('A1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		// Кто продал
		$sheet->setCellValue('A3', 'Продавец');
		$sheet->setCellValue('B3', 'Интернет-зоомагазин Котофей (ИП Васин К.В.)');
		$sheet->getStyle('B3')->getFont()->setBold(true);
		$sheet->setCellValue('B4', sprintf('Адрес г. Барнаул, ул. Весеняя, дом 4. Телефон: %s', SiteSettings::getValueByCode('phone_1')));
		$sheet->setCellValue('B5', sprintf('ИНН %s, ОГРН %s', SiteSettings::getValueByCode('inn'), SiteSettings::getValueByCode('ogrn')));
		$sheet->mergeCells('B3:G3');
		$sheet->mergeCells('B4:G4');
		$sheet->mergeCells('B5:G5');


		// Список товаров
		$items = OrdersItems::find()->where(['order_id' => $order->id])->all();

		$line = 8;
		$start_table = $line;
		$sheet->setCellValue("A{$line}", '№');
		$sheet->setCellValue("B{$line}", 'Наименование');
		$sheet->setCellValue("C{$line}", 'Артикул');
		$sheet->setCellValue("D{$line}", 'Количество');
		$sheet->setCellValue("E{$line}", 'Ед.');
		$sheet->setCellValue("F{$line}", 'Цена');
		$sheet->setCellValue("G{$line}", 'Сумма');
		foreach ($items as $count => $item) {
			$line++;
			$sheet->setCellValue("A{$line}", ++$count);
			$sheet->setCellValue("B{$line}", $item->name);
			if ($item->product) {
				$sheet->setCellValue("C{$line}", $item->product->article);
			} else {
				$sheet->setCellValue("C{$line}", '');
			}
			$sheet->setCellValue("D{$line}", $item->count);
			$sheet->setCellValue("E{$line}", 'Шт.');
			$sheet->setCellValue("F{$line}", $item->price);
			$sheet->setCellValue("G{$line}", $item->count * $item->price);
		}

		// Рамка для таблицы
		$sheet->getStyle("A{$start_table}:G{$line}")->applyFromArray(
			array(
				'borders' => array(
					'allBorders' => array(
						'borderStyle' => Border::BORDER_THIN
					)
				)
			)
		);

		$line++;

		$sheet->setCellValue("F{$line}", 'Итого');
		$sheet->setCellValue("G{$line}", OrderStatistic::orderSummary($order->id));

		$line = $line + 2;
		$result = (new \MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => OrderStatistic::orderSummary($order->id)]);
		$sheet->setCellValue("A{$line}", Yii::$app->i18n->format(sprintf("Всего отпущено на сумму %s {n, plural, =0{Пусто} =1{рубль} one{рубль} few{рублей} many{рублей} other{Ошибка}}", $result), ['n' => OrderStatistic::orderSummary($order->id)], 'ru_RU'));
		$sheet->mergeCells("A{$line}:B{$line}");

		$line = $line + 2;
		$sheet->setCellValue("A{$line}", 'Отпустил        ________        Расшифровка       ________');
		$sheet->mergeCells("A{$line}:B{$line}");


		// save file
		$writer = new Xlsx($spreadsheet);
//		$writer->save("$file_name");

		header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}");

		$writer->save('php://output');
	}
}
