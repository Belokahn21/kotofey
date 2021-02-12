<?php

namespace app\controllers;

use app\modules\support\models\entity\SupportCategory;
use app\modules\user\models\entity\Auth;
use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\favorite\models\entity\Favorite;
use app\modules\geo\models\entity\Geo;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\news\models\entity\News;
use app\modules\news\models\entity\NewsCategory;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\promo\models\entity\Promo;
use app\modules\short_link\models\entity\ShortLinks;
use app\modules\user\models\entity\Billing;
use app\modules\user\models\entity\UserResetPassword;
use app\modules\vacancy\models\entity\Vacancy;
use app\modules\catalog\models\form\CatalogFilter;
use app\modules\user\models\form\PasswordRestoreForm;
use app\models\services\ReferalService;
use app\modules\site\models\tools\Debug;
use app\modules\seo\models\tools\Attributes;
use app\modules\user\models\entity\User;
use app\modules\seo\models\tools\og\OpenGraph;
use app\modules\seo\models\tools\og\OpenGraphProduct;
use app\modules\site\models\tools\System;
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['success', 'fail', 'test'])) $this->enableCsrfValidation = false;


        if (!Yii::$app->session->get('city_id')) {
            $CityDefault = Geo::find()->where(['is_default' => true])->one();
            if ($CityDefault) Yii::$app->session->set('city_id', $CityDefault->id);
        }


        $geo = CurrentGeo::find()->one();
        if ($geo)
            if ($geo->timeZone) date_default_timezone_set($geo->timeZone->value);


        return parent::beforeAction($action);
    }
}