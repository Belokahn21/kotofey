<?php

namespace app\modules\search\controllers;

use app\modules\search\models\search\ElasticsearchSynonymSearch;
use Yii;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\controllers\MainBackendController;
use yii\widgets\ActiveForm;

class ElasticsearchSynonymsBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\search\models\entity\ElasticsearchSynonyms';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new ElasticsearchSynonymSearch();
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
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден.');

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
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден.');
        if ($model->delete()) Alert::setSuccessNotify('Элемент удален.');
        return $this->redirect(['index']);
    }

    private function getModel($primaryKey)
    {
        return $this->modelClass::findOne($primaryKey);
    }
}