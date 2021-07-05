<?php

namespace app\modules\catalog\controllers;


use app\models\tool\parser\ParseProvider;
use yii\helpers\Json;
use yii\rest\Controller;

class FillRestBackendController extends Controller
{
    public function actionView($id)
    {
        $id = base64_decode($id);
        $factory = new ParseProvider($id);
        $factory->contract();

        return Json::encode($factory->getInfo());
    }
}