<?php

namespace app\modules\catalog\controllers;

use Yii;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use app\widgets\notification\Alert;
use app\modules\catalog\models\search\PriceSearchForm;
use app\modules\site\controllers\MainBackendController;

class PriceBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\catalog\models\entity\Price';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new PriceSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен.');
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
        if (!$model = $this->findModel($id)) throw new HttpException(404, 'Элемент не найден.');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->findModel($id)) throw new HttpException(404, 'Элемент не найден.');
        if ($model->delete()) Alert::setSuccessNotify('Элемент удален.');
        return $this->redirect(['index']);
    }

    private function findModel($primaryKey)
    {
        return $this->modelClass::findOne($primaryKey);
    }
}