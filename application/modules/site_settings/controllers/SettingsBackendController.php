<?php

namespace app\modules\site_settings\controllers;

use yii\web\Controller;

class SettingsBackendController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
