<?php

namespace app\modules\acquiring\controllers;

use app\modules\order\models\entity\Order;
use app\modules\payment\models\services\equiring\banks\Sberbank;
use app\modules\payment\models\services\equiring\EquiringTerminalService;
use app\modules\payment\models\services\equiring\auth\SberbankAuthBasic;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = '';

    public function actions()
    {
        return [];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
    }

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();
        $order_id = $data['order_id'];
        $order = Order::findOne($order_id);
        $module = \Yii::$app->getModule('acquiring');

        //settings
        $login = "";
        $password = "";

        if ($module->mode == 'test' && YII_ENV == 'dev') {
            $login = $module->test_login;
            $password = $module->test_password;
        }

        if ($module->mode == 'on' && YII_ENV == 'prod') {
            $login = $module->real_login;
            $password = $module->real_password;
        }

        if ($module->mode == 'off') {
            throw new \Exception('В настройках сайта отключена работа Эквайринга, измените значение mode_acquiring в настройках сайта.');
        }


        $terminal = new EquiringTerminalService(new Sberbank(new SberbankAuthBasic($login, $password)));

        $result = $terminal->createOrder($order);


        if (!is_array($result) || !array_key_exists('orderId', $result) || !array_key_exists('formUrl', $result)) return $result;

        $successSaveEquiring = $terminal->saveHistoryPaymentTransaction($order, $result['orderId']);

        if ($successSaveEquiring['status'] == 200) return $result;

        return $successSaveEquiring;
    }

    public function actionView($id)
    {
    }

    public function actionDelete($id)
    {
    }

}
