<?php

namespace app\modules\delivery\controllers;

use app\modules\delivery\models\service\delivery\tariffs\services\ProvideTariff;
use app\modules\delivery\models\service\DeliveryCalculateService;
use yii\rest\Controller;

class RestCalculateController extends Controller
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
        $data = \Yii::$app->request->post();
        $prov_tarif = new ProvideTariff();

        $service = new DeliveryCalculateService($data['service']);
        return $service->getPriceInfo($prov_tarif->make($data));
    }
}