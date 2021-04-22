<?php

namespace app\modules\reviews\controllers;

use yii\web\Controller;

class ReviewsBackendController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
