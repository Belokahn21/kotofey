<?php


namespace app\modules\mailer\controllers;

use app\modules\site\controllers\MainBackendController;

class TemplatesBackendController extends MainBackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}