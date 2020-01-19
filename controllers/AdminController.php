<?php

namespace app\controllers;

use app\models\entity\Category;
use app\models\entity\Delivery;
use app\models\entity\Geo;
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
use app\models\entity\Promo;
use app\models\entity\Providers;
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
use app\models\entity\Vacancy;
use app\models\rbac\AuthAssignment;
use app\models\rbac\AuthItem;
use app\models\search\AuthItemSearchForm;
use app\models\search\CategorySearchForm;
use app\models\search\DeliverySearchForm;
use app\models\search\GeoSearchForm;
use app\models\search\InformersSearchForm;
use app\models\search\InformersValuesSearchForm;
use app\models\search\NewsSearchForm;
use app\models\search\NewsCategorySearchForm;
use app\models\search\OrderSearchForm;
use app\models\search\PermissionsSearchForm;
use app\models\search\ProductPropertiesSearchForm;
use app\models\search\ProductSearchForm;
use app\models\search\PromocodeSearchForm;
use app\models\search\ProvidersSearchForm;
use app\models\search\SettingsSearchForm;
use app\models\search\ShortLinksSearchModel;
use app\models\search\SlidersImagesSearchForm;
use app\models\search\SlidersSearchForm;
use app\models\search\StockSearchForm;
use app\models\search\VacancySearchForm;
use app\models\tool\Debug;
use app\models\tool\export\YandexCatalogExport;
use app\models\tool\export\YMLExport;
use app\widgets\notification\Alert;
use Codeception\Lib\Di;
use yii\filters\AccessControl;
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

            if(Yii::$app->request->isPost){
                // validate for ajax request
                if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
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
            if (!$order) {
                throw new HttpException(404, 'Заказ не найден');
            }

            if (Yii::$app->request->isPost) {
                if ($order->load(Yii::$app->request->post())) {
                    if ($order->update()) {
                        Alert::setSuccessNotify('Заказ успешно обновлён');
                        return $this->refresh();
                    }
                }
            }

            $items = OrdersItems::find()->where(['order_id' => $id])->all();
            return $this->render('detail/order', [
                'model' => $order,
                'items' => $items
            ]);
        }

        $model = new Order();
        $searchModel = new OrderSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());


        return $this->render('order', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    public function actionUser($id = null)
    {
        $model = new User(['scenario' => User::SCENARIO_INSERT]);
        $authAssigment = new AuthAssignment();
        $dataProvider = $model->search(\Yii::$app->request->post());
        $groups = AuthItem::find()->where(['type' => AuthItem::TYPE_ROLE])->all();

        // удалить юзера
        if (!empty($_GET['id']) && !empty($_GET['action']) && $_GET['action'] == 'auth') {
            $user = User::findOne(Yii::$app->request->get('id'));
            if ($user) {
                if (Yii::$app->user->login($user)) {
                    return $this->redirect('/admin/user/');
                }
            }
        }
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
                        } else {
                            Alert::setWarningNotify(Debug::modelErrors($model));
                            return $this->refresh();
                        }
                    } else {
                        Alert::setWarningNotify("Ошибка валидации");
                    }
                } else {
                    Alert::setWarningNotify("Ошибка получения данных из формы");
                }
            }

            return $this->render('detail/user', [
                'model' => $model,
                'groups' => $groups
            ]);
        }

        // сохранить юзера
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {

                    $model->setPassword($model->password);
                    $model->generateAuthKey();

                    if ($model->save()) {

                        if (!empty($model->group)) {
                            $authAssigment->addUserRole(AuthItem::findOne(['name' => $model->group]), $model);
                        }

                        return $this->refresh();
                    } else {
                        Alert::setErrorNotify(Debug::modelErrors($model));
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($model));
                    return $this->refresh();
                }
            }
            return $this->refresh();
        }

        return $this->render('user', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'groups' => $groups
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

    public function actionPermission()
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

    public function actionDelivery($id = null)
    {
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

    public function actionPayment($id = null)
    {

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
        $dataProvider = $model->search(\Yii::$app->request->get());

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
        ]);
    }

    public function actionSupport($id = null)
    {
        $model = new Tickets();
        $dataProvider = $model->search(\Yii::$app->request->get());

        return $this->render('support', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSupportCategory($id = null)
    {
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

    public function actionSupportstatus($id = null)
    {
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

    public function actionSettings($id = null)
    {
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

    public function actionProperties($id = null)
    {

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

    public function actionNews($id = null)
    {
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

    public function actionStocks($id = null)
    {
        if ($id) {
            $model = Stocks::findOne($id);
            if (Yii::$app->request->isPost) {
                if ($model->edit()) {
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
                return $this->refresh();
            }
        }

        return $this->render('stocks', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNewssections()
    {
        $model = new NewsCategory();
        $searchModel = new NewsCategorySearchForm();
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

        return $this->render('news-category', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInformers($id = null)
    {
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

    public function actionInformersValues($id = null)
    {

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

    public function actionSelling($id = null)
    {

        $model = new Selling();
        return $this->render('selling', [
            'model' => $model
        ]);
    }

    public function actionPromo($id = null)
    {

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

    public function actionProvider($id = null)
    {
        if (Yii::$app->request->get('action') == 'delete') {
            if (!$model = Providers::findOne($id)) {
                throw new HttpException(404, 'Запись не найдена');
            }

            if ($model->delete()) {
                Alert::setSuccessNotify('Поставщик успешно удалён');
                return $this->redirect('/admin/provider/');
            }
        }

        if ($id) {
            $model = Providers::findOne($id);
            $model->scenario = Providers::SCENARIO_UPDATE;
            if (Yii::$app->request->isPost) {
                if ($model->load(Yii::$app->request->post())) {
                    if ($model->update()) {
                        return $this->refresh();
                    }
                }
            }
            return $this->render('detail/provider', [
                'model' => $model
            ]);
        }

        $model = new Providers(['scenario' => Providers::SCENARIO_INSERT]);
        $searchModel = new ProvidersSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->refresh();
                }
            }
        }

        return $this->render('provider', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSliders($id = null)
    {
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

    public function actionSliderimages($id = null)
    {
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

    public function actionGeo($id = null)
    {
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
                'model' => $model
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
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSeo()
    {
        return $this->render('seo');
    }

    public function actionShortly($id = null)
    {
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

    public function actionManagement()
    {
        return $this->render('management');
    }

    public function actionVacancy($id = null)
    {
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
}
