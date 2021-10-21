<?php

namespace app\modules\order\controllers;

use Yii;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use app\widgets\notification\Alert;
use app\modules\site\models\tools\Debug;
use app\modules\order\models\entity\CustomerStatus;
use app\modules\order\models\helpers\CustomerPropertiesValuesHelper;
use app\modules\order\models\entity\CustomerProperties;
use app\modules\order\models\entity\CustomerPropertiesValues;
use app\modules\order\models\search\CustomerSearchForm;
use app\modules\site\controllers\MainBackendController;

class CustomerBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\order\models\entity\Customer';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new CustomerSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $properties = $this->getProperties();
        $propertiesValues = new CustomerPropertiesValues();
        $customer_status = $this->getCustomerStatus();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if (!$model->validate() || !$model->save()) {
                    Alert::setErrorNotify('Ошибка создания карточки товара.');
                    Debug::p($model->getErrors());
                    return $this->refresh();
                }
            }

            if (CustomerPropertiesValuesHelper::saveItems($model->phone)) {
                Alert::setSuccessNotify('Элемент успешно добавлен.');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'properties' => $properties,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'propertiesValues' => $propertiesValues,
            'customer_status' => $customer_status,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        $properties = $this->getProperties();
        $propertiesValues = new CustomerPropertiesValues();
        $customer_status = $this->getCustomerStatus();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if (!$model->validate() || $model->update() === false) {
                    Alert::setErrorNotify('Карточка клиента не обновлена.');
                    return $this->refresh();
                }
            }

            if (CustomerPropertiesValuesHelper::saveItems($model->phone)) {
                Alert::setSuccessNotify('Карточка клиента обновлена.');
                return $this->refresh();
            }
        }


        return $this->render('update', [
            'model' => $model,
            'properties' => $properties,
            'propertiesValues' => $propertiesValues,
            'customer_status' => $customer_status,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент удален');

        return $this->redirect(['index']);
    }

    private function getProperties()
    {
        return CustomerProperties::find()->all();
    }

    private function getCustomerStatus()
    {
        return CustomerStatus::find()->all();
    }
}