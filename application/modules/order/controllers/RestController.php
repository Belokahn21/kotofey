<?php


namespace app\modules\order\controllers;


use yii\helpers\Json;
use yii\rest\Controller;

class RestController extends Controller
{
    public function actionAdd()
    {
        return Json::encode([
            'text' => rand()
        ]);
    }
}