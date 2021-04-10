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


        $calcService = new DeliveryCalculateService('russian_post');
        $normalAddress = $calcService->getNormalAddress($filter['text']);


        return $normalAddress;
    }
}