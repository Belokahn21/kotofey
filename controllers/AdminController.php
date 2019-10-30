<?

namespace app\controllers;

use app\models\entity\Basket;
use app\models\entity\Category;
use app\models\entity\Delivery;
use app\models\entity\Informers;
use app\models\entity\InformersValues;
use app\models\entity\News;
use app\models\entity\Order;
use app\models\entity\OrderItems;
use app\models\entity\OrderStatus;
use app\models\entity\Pages;
use app\models\entity\NewsCategory;
use app\models\entity\Payment;
use app\models\entity\ProductProperties;
use app\models\entity\Promo;
use app\models\entity\Providers;
use app\models\entity\Selling;
use app\models\entity\SiteSettings;
use app\models\entity\Sliders;
use app\models\entity\SlidersImages;
use app\models\entity\Stocks;
use app\models\entity\support\SupportCategory;
use app\models\entity\support\SupportStatus;
use app\models\entity\support\Tickets;
use app\models\entity\User;
use app\models\forms\OrderForm;
use app\models\rbac\AuthAssignment;
use app\models\rbac\AuthItem;
use app\models\search\AuthItemSearchForm;
use app\models\search\CategorySearchForm;
use app\models\search\DeliverySearchForm;
use app\models\search\InformersSearchForm;
use app\models\search\InformersValuesSearchForm;
use app\models\search\NewsSearchForm;
use app\models\search\OrderSearchForm;
use app\models\search\OrderStatusSearchForm;
use app\models\search\NewsCategorySearchForm;
use app\models\search\PagesSearchForm;
use app\models\search\PaymentSearchForm;
use app\models\search\ProductPropertiesSearchForm;
use app\models\search\ProductSearchForm;
use app\models\search\PromocodeSearchForm;
use app\models\search\ProvidersSearchForm;
use app\models\search\SlidersImagesSearchForm;
use app\models\search\SlidersSearchForm;
use app\models\search\StockSearchForm;
use app\models\search\TicketsSearchForm;
use app\models\search\UserSearchForm;
use app\models\tool\Currency;
use app\models\tool\Debug;
use app\models\tool\export\TiuExport;
use app\models\tool\export\YMLExport;
use app\models\tool\Price;
use app\models\tool\System;
use app\models\tool\vk\VKMethods;
use app\widgets\notification\Notify;
use yii\base\Model;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;
use Yii;
use yii\web\HttpException;
use yii\web\UploadedFile;

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
        $product = Product::find();
        $order = Order::find();

        return $this->render('index', [
            'product' => $product,
            'order' => $order,
        ]);
    }

    public function actionCatalog($id = null)
    {
        // удалить товар
        if (Yii::$app->request->get('action') == 'delete') {
            $item = Product::findOne($id);

            $item->removeOldImage();    // удалить превью

            $item->removeOldImages();   // удалить галерею

            if ($item->delete()) {
                return $this->redirect('/admin/catalog/');
            }
        }

        // экспорт
        if (isset($_GET['export']) && !empty($_GET['export'])) {

            $ymlExport = new YMLExport();
            $ymlExport->create();


        }

        if ($id == null) {
            $model = new Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
            $searchModel = new ProductSearchForm();
            $dataProvider = $searchModel->search(\Yii::$app->request->get());
            $properties = ProductProperties::find()->all();

            if ($model->createProduct()) {
                return $this->refresh();
            }

            return $this->render('catalog', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'properties' => $properties,
            ]);
        }

        $model = Product::findOne($id);
        $model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
        $properties = ProductProperties::find()->all();

        if (Yii::$app->request->get('action') == 'copy') {


            if (Yii::$app->request->post('action') == 'Копировать') {
                $model->id = null;
                $model->article = null;
                $model->isNewRecord = true;
                $model->scenario = Product::SCENARIO_NEW_PRODUCT;
                if ($model->createProduct()) {
                    return $this->redirect('/admin/catalog/');
                }
            }

        }

        if ($model->updateProduct()) {
            return $this->refresh();
        }

        return $this->render('detail/catalog', [
            'model' => $model,
            'properties' => $properties,
        ]);
    }

    public function actionCategory($id = null)
    {
        if ($id) {
            $model = Category::findOne($id);
            $model->scenario = Category::SCENARIO_UPDATE_CATEGORY;

            if (\Yii::$app->request->isPost) {
                if ($model->load(\Yii::$app->request->post())) {

                    $model->upload();

                    if ($model->validate()) {
                        if ($model->save()) {
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

        $model = new Category(['scenario' => Category::SCENARIO_NEW_CATEGORY]);
        $searchModel = new CategorySearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if ($model->createCategory()) {
            return $this->refresh();
        }

        return $this->render('category', [
            'model' => $model,
            'categories' => $model->categoryTree(),
            'searchModel' => $searchModel,
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

            $items = OrderItems::findAll(['orderId' => (int)Yii::$app->request->get('id')]);
            if ($items) {
                foreach ($items as $item) {
                    $item->delete();
                }
            }

            return $this->redirect('/admin/order/');
        }

        if ($id) {
            $order = Order::findOne($id);

            if (Yii::$app->request->isPost) {
                if ($order->load(Yii::$app->request->post())) {
                    if ($order->update()) {

                        if ($order->product_id) {

                            foreach ($order->product_id as $productId) {
                                $basket = new Basket();
                                $basket->product = Product::findOne($productId);
                                $basket->count = 1;
                                $basket->add();
                            }

                            OrderItems::deleteAll(['orderId' => $order->id]);

                            $items = new OrderItems();
                            $items->orderId = $order->id;
                            $items->saveItems();

                            $basket->clear();

                        }
                    }
                }
            }

            return $this->render('detail/order', [
                'model' => $order
            ]);
        }

        $model = new Order();
        $dataProvider = $model->search(\Yii::$app->request->get());


        return $this->render('order', [
            'dataProvider' => $dataProvider,
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

                    if (!empty($model->password)) {
                        $model->setPassword($model->password);
                    }

                    if ($model->validate()) {
                        if ($model->update()) {
                            Notify::setSuccessNotify("Информация о пользователе успешно обновлена");
                            return $this->refresh();
                        } else {
                            Notify::setWarningNotify("Ошибка во время обновления данных");
                        }
                    } else {
                        Notify::setWarningNotify("Ошибка валидации");
                    }
                } else {
                    Notify::setWarningNotify("Ошибка получения данных из формы");
                }
            }

            return $this->render('detail/user', [
                'model' => $model,
            ]);
        }

        // сохранить юзера
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {

                $model->setPassword($model->password);
                $model->generateAuthKey();

                if ($model->validate()) {

                    if ($model->save()) {

                        if (!empty($model->role)) {
                            $authAssigment->addUserRole(AuthItem::findOne(['name' => $model->role]), $model);
                        }

                        return $this->refresh();
                    }
                }
            }
            return $this->refresh();
        }

        return $this->render('user', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGroup()
    {
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
            'model' => $model
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
            if ($model->createDelivery() === true) {
                return $this->refresh();
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
        $searchModel = new PaymentSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->createPayment() === true) {
                return $this->refresh();
            }
        }


        return $this->render('payment', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatus()
    {
        $status = new OrderStatus();
        $searchModel = new OrderStatusSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($status->createStatus()) {
                return $this->refresh();
            }
        }
        return $this->render('status', [
            'model' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSupport($id = null)
    {
        $status = new Tickets();
        $searchModel = new TicketsSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('support', [
            'model' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSupportcategory($id = null)
    {
        $model = new SupportCategory();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
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
        $paramsList = SiteSettings::find()->all();

        if ($id) {
            $model = SiteSettings::findOne($id);

            if (\Yii::$app->request->isPost) {
                if ($model->load(\Yii::$app->request->post())) {
                    if ($model->validate()) {
                        if ($model->update()) {
                            Notify::setSuccessNotify("Настройки обновлены");
                            return $this->redirect('/admin/settings/' . $id . '/');
                        }
                    }
                }
            }

            return $this->render('detail/settings', [
                'model' => $model,
                'paramsList' => $paramsList,
            ]);

        }

        if ($id == null) {
            if (\Yii::$app->request->isPost) {
                if ($model->load(\Yii::$app->request->post())) {

                    if ($_GET['type'] == 'file') {
                        $model->file = UploadedFile::getInstance($model, 'file');

                        if (!empty($model->file)) {
                            $fileName = substr(md5($model->file->baseName), 0, 32) . '.' . $model->file->extension;
                            $path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;

                            $model->file->saveAs($path);
                            $model->value = "/web/upload/" . $fileName;
                        }
                    }

                    if ($model->validate()) {
                        if ($model->save()) {
                            Notify::setSuccessNotify("Настройки сохранены");
                            return $this->redirect('/admin/settings/');
                        }
                    }
                }
            }
        }

        return $this->render('settings', [
            'model' => $model,
            'paramsList' => $paramsList
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

            return $this->render('detail/pages', [
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

        return $this->render('pages', [
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

        return $this->render('pagesections', [
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

    public function actionInformersvalues($id = null)
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
                        return $this->refresh();
                    }
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
            $model->scenario = Providers::SCENARIO_UPDATE;
            if (Yii::$app->request->isPost) {
                if ($model->load(Yii::$app->request->post())) {
                    if ($model->update()) {
                        return $this->refresh();
                    }
                }
            }
            return $this->render('detail/sliders_images', [
                'model' => $model
            ]);
        }

        $model = new SlidersImages(['scenario' => SlidersImages::SCENARIO_INSERT]);
        $searchModel = new SlidersImagesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
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
}
