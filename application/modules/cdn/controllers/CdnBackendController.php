<?php

namespace app\modules\cdn\controllers;

use app\modules\site\controllers\MainBackendController;

class CdnBackendController extends MainBackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
