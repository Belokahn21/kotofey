<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Product;
use yii\helpers\Json;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    protected function verbs()
    {
        return [
            'get' => ['GET']
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function actionGet($product_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Json::encode(Product::find()->select(['name', 'price', 'purchase'])->where(['id' => $product_id])->one());
    }
}