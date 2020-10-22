<?php

namespace app\modules\media\controllers;

use yii\web\Controller;

class MediaBackendController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
