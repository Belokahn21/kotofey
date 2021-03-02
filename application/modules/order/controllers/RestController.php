<?php


namespace app\modules\order\controllers;


use app\modules\order\models\entity\Order;
use yii\helpers\Json;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    protected function verbs()
    {
        return [
            'get' => ['GET'],
            'add' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionAdd()
    {
        return Json::encode([
            'text' => rand()
        ]);
    }

    public function actionGet()
    {
        return Json::encode(Order::find()->all());
    }
}