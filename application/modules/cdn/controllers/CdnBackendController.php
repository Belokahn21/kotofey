<?php

namespace app\modules\cdn\controllers;

use app\modules\site\controllers\MainBackendController;

class CdnBackendController extends MainBackendController
{
    public function actionIndex()
    {
        /* this react component Media */
        return $this->render('index');
    }
}
