<?php

namespace app\modules\rest\controllers;

use yii\helpers\Json;
use yii\web\Controller;

class ProductController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $requestData = $_POST['element'];
        return Json::encode($requestData);
    }
}
