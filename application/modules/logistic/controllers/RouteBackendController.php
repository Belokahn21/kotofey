<?php

namespace app\modules\logistic\controllers;

use app\modules\order\models\entity\Order;
use yii\web\Controller;

class RouteBackendController extends Controller
{
    public function actionIndex()
    {
        $models = Order::find();
        $models = $models->all();


        return $this->render('index', [
            'models' => $models,
        ]);
    }
}
