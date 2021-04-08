<?php

namespace app\modules\logger\controllers;

use app\modules\logger\models\entity\Logger;
use yii\web\Controller;

class LogBackendController extends Controller
{
    public function actionIndex()
    {
        $model = new Logger();
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
