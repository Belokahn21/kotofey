<?php

namespace app\modules\compare\controllers;

use yii\web\Controller;

class CompareController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
