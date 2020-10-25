<?php

namespace app\modules\cdek\controllers;


use app\modules\cdek\models\entity\CdekGeo;
use app\modules\cdek\models\helpers\CdekDeliveryHelper;
use yii\helpers\Json;
use yii\rest\Controller;

class RestSizeController extends Controller
{
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
        return Json::encode(CdekDeliveryHelper::getBoxSizes());
    }
}