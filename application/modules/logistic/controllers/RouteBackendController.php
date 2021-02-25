<?php

namespace app\modules\logistic\controllers;

use yii\web\Controller;

class RouteBackendController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
