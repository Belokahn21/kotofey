<?php

namespace app\controllers;

use app\modules\basket\models\entity\Basket;
use app\modules\compare\models\entity\Compare;
use app\modules\favorite\models\entity\Favorite;
use app\modules\geo\models\entity\Geo;
use app\modules\order\models\entity\OrdersItems;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\todo\models\entity\TodoList;
use app\modules\user\models\entity\User;
use app\modules\user\models\entity\Billing;
use app\modules\compare\models\service\CompareService;
use app\modules\order\models\service\DeliveryTimeService;
use app\models\tool\parser\ParseProvider;
use app\widgets\cookie\CookieWidget;
use app\widgets\notification\NotifyWidget;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\catalog\models\entity\Product;
use yii\web\HttpException;

class AjaxController extends Controller
{
    public $layout = "ajax";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'tobasket' => ['post'],
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
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionExist()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Json::decode(file_get_contents('php://input'));
        $code = $data['code'];
        $response = false;

        if ($data['vendorId'] == 4) {
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                        "Cookie: beget=begetok\r\n"
                )
            );

            $context = stream_context_create($opts);
            $url = "http://www.sat-altai.ru/catalog/?c=shop&a=item&number={$code}&category=";
            $file = file_get_contents($url, false, $context);

            $response = stristr($file, '<span class=sklad>В наличии</span>') !== false;
        }

        return Json::encode($response);
    }
}
