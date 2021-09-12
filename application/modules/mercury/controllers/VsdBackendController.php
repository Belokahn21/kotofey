<?php

namespace app\modules\mercury\controllers;

use app\modules\mercury\models\service\MercuryService;
use app\modules\site\controllers\MainBackendController;
use yii\web\Controller;

class VsdBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $vsd = new MercuryService();
        $vsd->listVSD();

        return $this->render('index');
    }
}
