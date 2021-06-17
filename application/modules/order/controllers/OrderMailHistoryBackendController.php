<?php

namespace app\modules\order\controllers;


use app\modules\order\models\entity\OrderMailHistory;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class OrderMailHistoryBackendController extends Controller
{
    public function actionIndex()
    {
    }

    public function actionUpdate($id)
    {
        if (!$model = OrderMailHistory::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = OrderMailHistory::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален.');

        return $this->redirect(['index']);
    }
}