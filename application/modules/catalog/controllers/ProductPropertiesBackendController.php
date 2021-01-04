<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\search\ProductPropertiesSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class ProductPropertiesBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\catalog\models\entity\Properties';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new ProductPropertiesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Свойство успешно добавлено');
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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Свойство успешно обновлено');
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
        if ($this->modelClass::findOne($id)->delete()) {
            Alert::setSuccessNotify('Свойство товара удалено');
        }

        return $this->redirect(['index']);
    }
}