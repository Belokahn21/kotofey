<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\search\ProductPropertiesSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProductPropertiesBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Properties();
        $searchModel = new ProductPropertiesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render("index", [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = SaveProductProperties::findOne($id);

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render("update", [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (SaveProductProperties::findOne($id)->delete()) {
            Alert::setSuccessNotify('Свойство товара удалено');
        }

        return $this->redirect(['index']);
    }
}