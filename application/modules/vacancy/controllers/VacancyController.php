<?php

namespace app\modules\vacancy\controllers;


use app\modules\vacancy\models\entity\Vacancy;
use yii\web\Controller;
use yii\web\HttpException;

class VacancyController extends Controller
{
    public function actionIndex()
    {
        $models = Vacancy::find()->where(['is_active' => true])->all();
        return $this->render('index', [
            'models' => $models
        ]);
    }

    public function actionView($id)
    {
        if (!$model = Vacancy::findOneBySlug($id)) throw new HttpException(404, 'Элемент не найден');
        return $this->render('view', [
            'model' => $model
        ]);
    }
}