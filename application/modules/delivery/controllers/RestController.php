<?php

namespace app\modules\delivery\controllers;

use app\modules\delivery\models\entity\Delivery;
use yii\helpers\Json;
use yii\rest\Controller;

class RestController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    protected function verbs()
    {
        return [
            'get' => ['GET'],
        ];
    }

    public function actionGet()
    {
        return Json::encode(Delivery::find()->all());
    }

    public function actionGetCheckout()
    {
        $outData = [];

        foreach (Delivery::find()->where(['active' => true])->all() as $delivery) {
            $outData[] = [
                'id' => $delivery->id,
                'name' => $delivery->name,
                'imageUrl' => "/upload/$delivery->image"
            ];
        }

        return Json::encode($outData);
    }
}