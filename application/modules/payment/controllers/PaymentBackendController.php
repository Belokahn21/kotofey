<?php

namespace app\modules\payment\controllers;

use app\models\entity\Payment;
use app\modules\payment\models\search\PaymentSearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class PaymentBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Payment();
        $searchModel = new PaymentSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Способ оплаты создан');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Payment::findOne($id);

        if (!$model) {
            throw new HttpException(404, 'Оплата не сущесвует');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Способ оплаты обновлен');
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
        if (Payment::findOne($id)->delete()) {
            Alert::setSuccessNotify('Оплата успешно удален');
        }

        return $this->redirect(['index']);
    }
}
