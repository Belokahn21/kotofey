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
            'all' => ['GET']
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

    public function actionAll($product_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = Product::find();

        if ($product_id) $query->where(['id' => $product_id]);

        if ($phrase = \Yii::$app->request->get('name')) {
            foreach (explode(' ', $phrase) as $text_line) {
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