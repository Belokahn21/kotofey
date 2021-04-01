<?php

namespace app\modules\delivery\controllers;

use app\modules\delivery\models\service\delivery\RussianPost;
use app\modules\delivery\models\service\DeliveryCalculateService;
use yii\rest\Controller;

class RestCalculateController extends Controller
{
    public function get()
    {
        $data = \Yii::$app->request->post();
        $delivery = null;
        if ($data['delivery'] == 'russian_post') {
            $delivery = new RussianPost();
        }


        return new DeliveryCalculateService($delivery, $data['address']);
    }
}