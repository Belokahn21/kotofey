<?php

namespace app\modules\catalog\controllers;


use app\models\entity\ProductProperties;
use app\modules\catalog\models\search\ProductPropertiesSearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;

class ProductPropertiesBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new ProductProperties();
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
        $model = ProductProperties::findOne($id);

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
        if (ProductProperties::findOne($id)->delete()) {
            Alert::setSuccessNotify('Свойство товара удалено');
        }

        return $this->redirect(['index']);
    }
}