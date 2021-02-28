<?php

namespace app\modules\payment\controllers;

use app\modules\payment\models\entity\Payment;
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
        return Json::encode(Payment::find()->all());
    }


    public function actionGetCheckout()
    {
        $outData = [];

        foreach (Payment::find()->where(['active' => true])->all() as $payment) {
            $outData[] = [
                'id' => $payment->id,
                'name' => $payment->name,
                'imageUrl' => "/upload/$payment->image"
            ];
        }

        return Json::encode($outData);
    }
}