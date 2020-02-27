<?php

namespace app\modules\rest\controllers;

use yii\helpers\Json;
use yii\web\Controller;

class ProductController extends Controller
{
    public function actionCreate()
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Json::encode('hello');
    }
}
