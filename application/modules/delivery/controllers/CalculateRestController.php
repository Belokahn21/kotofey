<?php

namespace app\modules\delivery\controllers;

use yii\rest\Controller;
use app\modules\basket\models\entity\Basket;
use app\modules\delivery\models\service\DeliveryService;

class CalculateRestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $post_data = \Yii::$app->request->post();
        $basket = Basket::findAll();
        $products = [];
        foreach ($basket as $ordersItems) {
            $products[] = $ordersItems->product;
        }

        $ds = new DeliveryService($products);
        return $ds->availableTariffs($post_data);
    }
}