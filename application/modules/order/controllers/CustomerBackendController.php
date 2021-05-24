<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\CustomerProperties;
use app\modules\order\models\entity\CustomerPropertiesValues;
use app\modules\order\models\search\CustomerPropertiesSearchForm;
use Yii;
use app\widgets\notification\Alert;
use app\modules\order\models\entity\Customer;
use app\modules\site\controllers\MainBackendController;
use yii\web\HttpException;

class CustomerBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\order\models\entity\Customer';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new CustomerPropertiesSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $properties = CustomerProperties::find()->all();
        $propertiesValues = new CustomerPropertiesValues();

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
            'properties' => $properties,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'propertiesValues' => $propertiesValues,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        $properties = CustomerProperties::find()->all();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен.');
                    return $this->refresh();
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
            'properties' => $properties,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент удален');

        return $this->redirect(['index']);
    }
}