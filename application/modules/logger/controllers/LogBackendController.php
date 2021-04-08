<?php

namespace app\modules\logger\controllers;

use app\modules\logger\models\entity\Logger;
use app\modules\logger\models\search\LoggerSearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class LogBackendController extends Controller
{
    public function actionIndex()
    {
        $model = new Logger();
        $searchModel = new LoggerSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());


        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = Logger::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Запись в логах удалена.');

        return $this->redirect(['index']);
    }
}
