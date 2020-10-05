<?php

namespace app\modules\promotion\controllers;

use yii\web\Controller;

class PromotionBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        return $this->render('index');
    }
}
