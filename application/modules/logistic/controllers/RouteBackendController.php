<?php

namespace app\modules\logistic\controllers;

use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use yii\web\Controller;

class RouteBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $models = Order::find()->where(['is_close' => false, 'status' => 8]);
        $models = $models->all();


        return $this->render('index', [
            'models' => $models,
        ]);
    }
}
