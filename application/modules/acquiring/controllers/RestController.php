<?php

namespace app\modules\acquiring\controllers;

use app\modules\order\models\entity\Order;
use app\modules\payment\models\services\equiring\banks\Sberbank;
use app\modules\payment\models\services\equiring\SberbankAuthBasic;
use yii\rest\ActiveController;
use yii\rest\Controller;

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
//        $data = Json::decode(file_get_contents('php://input'));
        $data = \Yii::$app->request->post();
        $order_id = $data['order_id'];

        $payment = new Sberbank(new SberbankAuthBasic('T2222889641-api', 'T2222889641'));
        return $payment->getPaymentLink(Order::findOne($order_id));
    }

    public function actionView($id)
    {
    }

    public function actionDelete($id)
    {
    }

}
