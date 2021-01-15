<?php

namespace app\modules\pets\controllers;

use app\modules\pets\models\entity\Animal;
use yii\web\Controller;

class AnimalBackendController extends Controller
{
    public $modelClass = 'app\modules\pets\models\entity\Animal';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
