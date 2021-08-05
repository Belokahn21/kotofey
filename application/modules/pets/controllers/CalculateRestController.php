<?php

namespace app\modules\pets\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class CalculateRestController extends ActiveController
{
    public $modelClass = 'app\modules\pets\models\entity\Breed';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $action = parent::actions();
        unset($action['create']);
    }

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();
        $out = [];


        foreach (Product::find()->limit(5)->all() as $product) {
            $imageUrl = ProductHelper::getImageUrl($product);
            $href = ProductHelper::getDetailUrl($product);


            $product = ArrayHelper::toArray($product);
            $product['imageUrl'] = $imageUrl;
            $product['href'] = $href;

            $out[] = $product;
        }


        return $out;
    }
}