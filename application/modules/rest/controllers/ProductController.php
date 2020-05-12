<?php

namespace app\modules\rest\controllers;

use app\models\entity\Product;
use yii\helpers\Json;
use yii\rest\Controller;

class ProductController extends Controller
{
    const ERROR_CODE = 400;
    const SUCCESS_CODE = 200;

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

    public function actionGet()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = Product::find();

        if ($text = \Yii::$app->request->get('text')) {
            foreach (explode(' ', $text) as $text_line) {
                $query->andFilterWhere([
                    'or',
                    ['like', 'name', $text_line],
                    ['like', 'feed', $text_line]
                ]);
            }
        }

        return Json::encode($query->all());
    }
}
