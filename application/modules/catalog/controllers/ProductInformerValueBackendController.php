<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\search\SaveInformersValuesSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class ProductInformerValueBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new SaveInformersValues();
        $searchModel = new SaveInformersValuesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Значение справочника добавлено');
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($model));
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
        $model = SaveInformersValues::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Запись не существует');
        }
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Значение справочника обновлено');
                        return $this->refresh();
                    }
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (SaveInformersValues::findOne($id)->delete()) {
            Alert::setSuccessNotify('Значение справочника удалено');
        }
        return $this->redirect(['index']);
    }
}