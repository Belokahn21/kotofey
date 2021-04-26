<?php

namespace app\modules\mailer\controllers;

use app\modules\site\controllers\MainBackendController;
use yii\web\Controller;

class EventsBackendController extends MainBackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
