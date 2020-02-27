<?php

namespace app\modules\rest\controllers;

use app\models\entity\Product;
use app\models\tool\Debug;
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
        $json = file_get_contents('php://input');
        $data = Json::decode($json);
        $product = Product::findOne(['code' => $data['article']]);

        if (!$product) {
            throw new \Exception('Данный товар уже существует');
        }


        return;
    }
}
