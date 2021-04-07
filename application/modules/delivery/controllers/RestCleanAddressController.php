<?php


namespace app\modules\delivery\controllers;

use yii\rest\Controller;
use app\modules\delivery\models\service\DeliveryCalculateService;

class RestCleanAddressController extends Controller
{
    public function get()
    {
        $filter = \Yii::$app->request->get('filter');


        $calcService = new DeliveryCalculateService('russian_post');
        $normalAddress = $calcService->getNormalAddress($filter['text']);


        return $normalAddress;
    }
}