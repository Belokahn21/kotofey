<?php

namespace app\modules\acquiring\controllers;

use yii\rest\Controller;

class RestController extends Controller
{
    protected function verbs()
    {
        return [
            'get' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionGet()
    {
    }

    public function actionCreate()
    {
    }

    public function actionDelete()
    {
    }
}
