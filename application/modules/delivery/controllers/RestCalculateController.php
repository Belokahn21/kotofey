<?php

namespace app\modules\delivery\controllers;

use app\modules\delivery\models\service\delivery\RussianPostApi;
use app\modules\delivery\models\service\DeliveryCalculateService;
use yii\rest\Controller;

class RestCalculateController extends Controller
{
    public function get()
    {
        $data = \Yii::$app->request->post();

        return new DeliveryCalculateService($data['service'], $data['address']);
    }
}