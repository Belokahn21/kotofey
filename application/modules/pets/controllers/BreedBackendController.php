<?php

namespace app\modules\pets\controllers;

use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\search\BreedSearchForm;
use Yii;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use app\widgets\notification\Alert;
use app\modules\site\controllers\MainBackendController;

class BreedBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\pets\models\entity\Breed';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new BreedSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $animals = $this->findAnimals();

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
            'animals' => $animals,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->findModel($id)) throw new HttpException(404, 'Элемент не найден.');
        $animals = $this->findAnimals();

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

        return $this->render('update', ['model' => $model, 'animals' => $animals]);
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

    private function findAnimals()
    {
        return Yii::$app->cache->getOrSet('breed-animals', function () {
            return Animal::find()->all();
        });
    }
}