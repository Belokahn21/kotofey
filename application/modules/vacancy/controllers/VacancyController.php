<?php

namespace app\modules\vacancy\controllers;


use app\modules\vacancy\models\entity\Vacancy;
use yii\web\Controller;

class VacancyController extends Controller
{
    public function actionIndex()
    {
        $models = Vacancy::find()->where(['is_active' => true])->all();
        return $this->render('index', [
            'models' => $models
        ]);
    }
}