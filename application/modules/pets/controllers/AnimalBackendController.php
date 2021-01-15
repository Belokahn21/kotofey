<?php

namespace app\modules\pets\controllers;

use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class AnimalBackendController extends Controller
{
    public $modelClass = 'app\modules\pets\models\entity\Animal';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен');
                    return $this->refresh();
                }
            }
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен');
                    return $this->refresh();
                }
            }
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален');

        return $this->redirect(['index']);
    }
}
