<?php

namespace app\modules\site\controllers;

use app\models\tool\seo\Attributes;
use app\models\tool\System;
use app\modules\order\models\service\NotifyService;
use app\modules\site\models\forms\GrumingForm;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\UserResetPassword;
use app\modules\user\models\form\PasswordRestoreForm;
use app\widgets\notification\Alert;
use Yii;
use app\models\services\ReferalService;
use app\modules\geo\models\entity\CurrentGeo;
use app\modules\geo\models\entity\Geo;
use yii\web\Controller;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//            'auth' => [
//                'class' => 'yii\authclient\AuthAction',
//                'successCallback' => [$this, 'onAuthSuccess'],
//            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Debug::isPageSpeed()) {
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

        }
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


        $GrumingForm = new GrumingForm();

        if ($GrumingForm->load(Yii::$app->request->post())) {
            if ($GrumingForm->validate()) {
                $notify = new NotifyService();
                if ($notify->sendVKAboutGruming($GrumingForm)) {
                    Alert::setSuccessNotify("Вы отправили заявку на услуги зоосалона. В течении часа с вами свяжется оператор и согласует детали!");
                    return $this->refresh('#gruming');
                }
            }
        }

        return $this->render('index');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
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

    public function actionAbout()
    {
        Attributes::metaDescription("Небольшой рассказ о нашей компании, наших целях и планах на будущее");
        Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
        return $this->render('about');
    }


    public function actionContacts()
    {
        Attributes::metaDescription("Контакты нашего интернет магазина");
        Attributes::canonical(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/");
        return $this->render('contacts');
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

    public function actionCache()
    {
        Yii::$app->cache->flush();
        Alert::setSuccessNotify('Кэш сброшен');
        return $this->redirect(['/']);
    }

    public function actionConsole()
    {
        return $this->render('console');
    }
}
