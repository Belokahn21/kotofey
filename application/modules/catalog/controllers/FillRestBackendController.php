<?php

namespace app\modules\catalog\controllers;


use app\models\tool\parser\ParseProvider;
use yii\helpers\Json;
use yii\rest\Controller;

class FillRestBackendController extends Controller
{
    public function actionCreate()
    {
        $id = \Yii::$app->request->post('link');
        $factory = new ParseProvider($id);
        $factory->contract();

        return $factory->getInfo();
    }
}