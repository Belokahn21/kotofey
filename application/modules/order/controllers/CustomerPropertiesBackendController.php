<?php

namespace app\modules\order\controllers;

use Yii;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\controllers\MainBackendController;
use app\modules\order\models\search\CustomerPropertiesSearchForm;

class CustomerPropertiesBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\order\models\entity\CustomerProperties';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new CustomerPropertiesSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен.');
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

        if ($model->delete()) Alert::setSuccessNotify('Элемент удален');

        return $this->redirect(['index']);
    }
}