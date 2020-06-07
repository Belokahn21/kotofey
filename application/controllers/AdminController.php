<?php

namespace app\controllers;

use app\models\entity\Category;
use app\modules\delivery\models\entity\Delivery;
use app\models\entity\Geo;
use app\models\entity\GeoTimezone;
use app\models\entity\Informers;
use app\models\entity\InformersValues;
use app\models\entity\News;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderStatus;
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
use app\models\entity\Vacancy;
use app\models\entity\Vendor;
use app\models\entity\VendorGroup;
use app\models\forms\FeedmakerForm;
use app\models\forms\SaleProductForm;
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
use app\modules\order\models\search\OrderSearchForm;
use app\models\search\OrderStatusSearchForm;
use app\models\search\PermissionsSearchForm;
use app\models\search\ProductPropertiesSearchForm;
use app\modules\catalog\models\search\ProductSearchForm;
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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;
use Yii;
use yii\web\HttpException;
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

            if (Yii::$app->request->get('out') == 'Y') {
                $name = Yii::getAlias('@app') . $backup->getNameDirDumps() . $backup->getNameFile();
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"" . $backup->getNameFile() . "\"");
                readfile($name);
                exit;
            }


            return $this->redirect(['admin/index']);
        }

        return $this->render('index', [
            'last_search' => $last_search
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

    public function actionSupport($id = null)
    {
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
                        Alert::setSuccessNotify('Промокод успешно создан');
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

    public function actionCache()
    {
        Yii::$app->cache->flush();
        return $this->redirect('/');
    }


    public function actionSaleProduct()
    {
        $model = new SaleProductForm();
        $sales = InformersValues::find()->where(['informer_id' => '10', 'active' => 1])->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    $selectedItems = ProductPropertiesValues::find()->where(['value' => $model->sale_id, 'property_id' => 11])->all();

                    $products = Product::find()->where(['id' => ArrayHelper::getColumn($selectedItems, 'product_id')])->all();
                    foreach ($products as $product) {
                        $transaction = Yii::$app->db->beginTransaction();
                        $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                        $product->discount_price = null;
                        if ($product->validate()) {
                            if ($product->update() === false) {
                                $transaction->rollBack();
                                return false;
                            }
                        }
                        if (!ProductPropertiesValues::findOne(['value' => $model->sale_id, 'product_id' => $product->id, 'property_id' => 11])->delete()) {
                            $transaction->rollBack();
                            return false;
                        }

                        $transaction->commit();
                    }

                    Alert::setSuccessNotify('Товары сняты с акции');
                    return $this->refresh();
                }
            }
        }

        return $this->render('sale-product', [
            'model' => $model,
            'sales' => $sales
        ]);
    }
}
