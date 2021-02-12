<?php

namespace app\controllers;

use app\modules\geo\models\entity\CurrentGeo;
use app\modules\geo\models\entity\Geo;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
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