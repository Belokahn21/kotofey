<?php

namespace app\controllers;

use app\models\entity\Auth;
use app\models\entity\Basket;
use app\models\entity\Category;
use app\models\entity\Delivery;
use app\models\entity\Favorite;
use app\models\entity\Geo;
use app\models\entity\InformersValues;
use app\models\entity\Order;
use app\models\entity\OrderBilling;
use app\models\entity\OrdersItems;
use app\models\entity\News;
use app\models\entity\NewsCategory;
use app\models\entity\Payment;
use app\models\entity\Product;
use app\models\entity\ProductProperties;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\Promo;
use app\models\entity\ShortLinks;
use app\models\entity\SiteReviews;
use app\models\entity\support\SupportCategory;
use app\models\entity\support\SupportMessage;
use app\models\entity\support\Tickets;
use app\models\entity\user\Billing;
use app\models\entity\Vacancy;
use app\models\forms\CatalogFilter;
use app\models\forms\DiscountForm;
use app\models\tool\Debug;
use app\models\tool\seo\Attributes;
use app\models\entity\User;
use app\models\tool\seo\og\OpenGraph;
use app\models\tool\seo\og\OpenGraphProduct;
use app\models\tool\System;
use app\widgets\notification\Alert;
use yii\data\Pagination;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Search;
use Yii;
use yii\web\HttpException;
use yii\web\Response;
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

//		if (System::isMobile() or Yii::$app->request->get('mobile') == "Y") {
//            $this->layout = "mobile";
//		}


        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $providers = InformersValues::find()->where(['active' => true, 'informer_id' => 1])->all();
        $news = News::find()->limit(3)->orderBy(['created_at' => SORT_DESC])->all();

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
            'news' => $news
        ]);
    }

    public function actionSearch()
    {
        $model = new Search();

        if ($model->load(\Yii::$app->request->get())) {
            $products = $model->search();
        }

        return $this->render('search', [
            'products' => $products
        ]);
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
        $product = Product::findBySlug($id);
        if (!$product instanceof Product) {
            throw new \yii\web\NotFoundHttpException("Товар не найден.");
        }


        $category = Category::findOne($product->category_id);

        if (!empty($product->seo_description)) {
            Attributes::metaDescription($product->seo_description);
        } else {
            if (!empty($product->description)) {
                Attributes::metaDescription($product->description);
            } else {
                Attributes::metaDescription(sprintf('В нашем интернет-магазине зоотоваров в продаже  имеется %s по низкой цене в Барнауле. За каждую покупку выполучите 5%% бонусов, а мы доставим бесплатно!', $product->name));
            }
        }

        if (!empty($product->seo_keywords)) {
            Attributes::metaKeywords($product->seo_keywords);
        } else {
            Attributes::metaKeywords(explode(';', sprintf("купить %s в барнауле;интернет-зоомагазин;зоомагазин интернет барнаул;анго зоомагазин интернет барнаул;интернет зоомагазин с доставкой", $product->name)));
        }

        Attributes::canonical(System::protocol() . "://" . System::domain() . "/product/" . $product->slug . "/");


        OpenGraphProduct::title($product->display);
        if (!empty($product->description)) {
            OpenGraph::description($product->description);
            Attributes::metaDescription($product->description);
        }
        OpenGraphProduct::type();
        OpenGraphProduct::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $product->slug . "/");
        OpenGraphProduct::amount($product->price);
        OpenGraphProduct::currency('RUB');

        if (!empty($product->image)) {
            OpenGraphProduct::image(System::protocol() . "://" . System::domain() . '/web/upload/' . $product->image);
        }

        $properties = ProductPropertiesValues::find()->where(['product_id' => $product->id])->andWhere(['not in', 'property_id', ProductProperties::find()->select('id')->where(['need_show' => 0])])->all();

        $left_product = Product::find()->where(['category_id' => $category->id, 'active' => true])->andWhere(['<>', 'id', $product->id])->orderBy(new Expression('rand()'))->one();
        $right_product = Product::find()->where(['category_id' => $category->id, 'active' => true])->andWhere(['<>', 'id', $product->id])->orderBy(new Expression('rand()'))->one();

        return $this->render('product', [
            'product' => $product,
            'left_product' => $left_product,
            'right_product' => $right_product,
            'category' => $category,
            'properties' => $properties
        ]);
    }

    public function actionBasket()
    {
        Attributes::canonical(System::protocol() . "://" . System::domain() . "/basket/");
        return $this->render('basket');
    }

    public function actionCheckout()
    {
        $delivery = Delivery::find()->where(['active' => 1])->all();
        $payment = Payment::find()->where(['active' => 1])->all();
        $basket = new Basket();
        $discount_model = new DiscountForm();
        $db = Yii::$app->db;

        if ($basket->isEmpty()) {
            return $this->redirect("/");
        }


        if (\Yii::$app->user->isGuest) {
            $order = new Order();
            $user = new User(['scenario' => User::SCENARIO_CHECKOUT]);
            $billing = new Billing();
            $items = new OrdersItems();

            // форма отправлена
            if (\Yii::$app->request->isPost) {

                // validate for ajax request
                if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($user);
                }


                $transaction = $db->beginTransaction();
                if ($user->load(Yii::$app->request->post()) && $user->validate()) {
                    if ($user->save() === false) {
                        $transaction->rollBack();
                        Alert::setErrorNotify(print_r($user->getErrors(), true));
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($user));
                    return $this->refresh();
                }

                $billing = Billing::findByUser($user->id);
                if ($billing->load(Yii::$app->request->post()) and $billing->validate()) {
                    if ($billing->update() === false) {
                        $transaction->rollBack();
                        Alert::setErrorNotify(Debug::modelErrors($billing));
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($billing));
                    return $this->refresh();
                }

                Yii::$app->user->login($user, Yii::$app->params['users']['rememberMeDuration']);


                $order->user_id = $user->id;
                if ($order->load(Yii::$app->request->post()) or $order->validate()) {
                    if ($order->save() === false) {
                        $transaction->rollBack();
                        Alert::setErrorNotify(Debug::modelErrors($order));
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($order));
                    return $this->refresh();
                }

                $order_billing = new OrderBilling();
                $order_billing->user_billing_id = $billing->id;
                $order_billing->order_id = $order->id;
                if ($order_billing->validate()) {
                    if (!$order_billing->save()) {
                        $transaction->rollBack();
                    }
                }

                $items->order_id = $order->id;
                if ($items->saveItems() === false) {
                    $transaction->rollBack();
                    Alert::setErrorNotify(Debug::modelErrors($items));
                    return $this->refresh();
                }

                Basket::clear();
                unset($_COOKIE['order']);
                Alert::setSuccessNotify("Заказ успешно создан создан");
                $transaction->commit();
                return $this->redirect('/');
            }

            return $this->render('checkout', [
                'discount_model' => $discount_model,
                'user' => $user,
                'billing' => $billing,
                'order' => $order,
                'delivery' => $delivery,
                'payment' => $payment,
            ]);
        } else {
            $order = new Order();
            $items = new OrdersItems();
            $user = User::findOne(Yii::$app->user->id);
            $user->scenario = User::SCENARIO_UPDATE;
            $billing = $user->billing;

            if (\Yii::$app->request->isPost) {
                $transaction = $db->beginTransaction();

                if ($discount_model->load(Yii::$app->request->post())) {
                    if ($discount_model->validate()) {
                        if ($discount_model->calc($order, 'promo_code') === false) {
                            $transaction->rollBack();
                        }
                    }
                }

                $order->user_id = $user->id;
                if ($order->load(Yii::$app->request->post()) or $order->validate()) {
                    if ($order->save() === false) {
                        $transaction->rollBack();
                        Alert::setErrorNotify(Debug::modelErrors($order));
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($order));
                    return $this->refresh();
                }

                $items->order_id = $order->id;


                if ($order->select_billing) {
                    $order_billing = new OrderBilling();
                    $order_billing->user_billing_id = $order->select_billing;
                    $order_billing->order_id = $order->id;
                    if ($order_billing->validate()) {
                        if (!$order_billing->save()) {
                            $transaction->rollBack();
                        }
                    }
                }

                if ($items->saveItems() === false) {
                    $transaction->rollBack();
                    Alert::setErrorNotify(Debug::modelErrors($items));
                    return $this->refresh();
                }

                Basket::clear();
                unset($_COOKIE['order']);
                Alert::setSuccessNotify("Заказ успешно создан создан");
                $transaction->commit();
                return $this->redirect('/');
            }

            return $this->render('checkout', [
                'discount_model' => $discount_model,
                'user' => $user,
                'billing' => $billing,
                'order' => $order,
                'delivery' => $delivery,
                'payment' => $payment,
            ]);
        }
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

    public function actionBilling($id = null)
    {
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

    public function actionSignin()
    {
        $model = new User(['scenario' => User::SCENARIO_LOGIN]);
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {

                    $user = User::findByEmail($model->email);
                    if ($user instanceof User) {
                        if (Yii::$app->user->login($user, Yii::$app->params['users']['rememberMeDuration'])) {
                            Alert::setSuccessNotify('Успешная авторизация');
                            return $this->redirect('/');
                        }
                    }

                }
            }
        }
        return $this->render('auth/signin', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
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

        if ($id) {
            $order = Order::findOne($id);

            if (empty($order)) {
                throw new \Exception("Такого заказа не существует");
            }

            if (!$order->hasAccess()) {
                throw new \Exception("Доступ к чужому заказу запрещён");
            }

            $items = OrdersItems::findAll(['order_id' => $order->id]);

            return $this->render('detail/order', [
                'order' => $order,
                'items' => $items,
            ]);
        }


        $orders = Order::findAll(['user_id' => \Yii::$app->user->id]);
        return $this->render('order', [
            'orders' => $orders
        ]);
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
                            Alert::setSuccessNotify("Обращение создано!");
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
                            Alert::setSuccessNotify("Обращение создано!");
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
                            Alert::setSuccessNotify("Сообщение отправлено!");
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
        Basket::getInstance()->clear();
        Promo::clear();
        Alert::setSuccessNotify("Корзина очищена!");
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
                            Alert::setSuccessNotify("Отзыв успешно добавлен!");
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
        $news = News::find()->all();

//        Attributes::metaKeywords("уход за натуральной кожей, уход за сумкой из натуральной кожи,");
        Attributes::metaDescription("Самые полезные и актуальные статьи о том как ухаживать за кожей, как выбрать правильно продукт и другие новости компани!");

        return $this->render('news', [
            'news' => $news,
            'categories' => $categories
        ]);
    }

    public function actionVacancy($id = null)
    {
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

    public function actionContacts()
    {
        Attributes::metaDescription("Контакты нашего интернет магазина");
        Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
        return $this->render('contacts');
    }

    public function actionBrands($id = null)
    {
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
        return $this->render('compare');
    }
}