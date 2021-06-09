<?php


namespace app\modules\delivery\controllers;

use yii\rest\Controller;
use app\modules\delivery\models\service\DeliveryCalculateService;

class CleanAddressRestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $filter = \Yii::$app->request->get('filter');
        $service = \Yii::$app->request->get('service', 'ru_post');

        $calcService = new DeliveryCalculateService($service);
        $normalAddress = $calcService->getNormalAddress($filter['text']);


        return $normalAddress;
    }
}