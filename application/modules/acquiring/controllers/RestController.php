<?php

namespace app\modules\acquiring\controllers;

use app\modules\order\models\entity\Order;
use app\modules\payment\models\services\equiring\banks\Sberbank;
use app\modules\payment\models\services\equiring\EquiringTerminalService;
use app\modules\payment\models\services\equiring\auth\SberbankAuthBasic;
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
        $data = \Yii::$app->request->post();
        $order_id = $data['order_id'];


        $terminal = new EquiringTerminalService(new Sberbank(new SberbankAuthBasic(\Yii::$app->params['acquiring']['sberbank']['login'], \Yii::$app->params['acquiring']['sberbank']['password'])));
        return $terminal->registerOrderToSite(Order::findOne($order_id));
    }

    public function actionView($id)
    {
    }

    public function actionDelete($id)
    {
    }

}
