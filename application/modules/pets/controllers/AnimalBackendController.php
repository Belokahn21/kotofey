<?php

namespace app\modules\pets\controllers;

use app\modules\pets\models\search\AnimalSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class AnimalBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\pets\models\entity\Animal';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new AnimalSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->post());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен');
                    return $this->refresh();
                }
            }
        }
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('update', [
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
