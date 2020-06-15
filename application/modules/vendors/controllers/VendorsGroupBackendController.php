<?php

namespace app\modules\vendors\controllers;

use app\widgets\notification\Alert;
use Yii;
use app\models\entity\VendorGroup;
use app\models\search\VendorGroupSearchForm;
use yii\web\Controller;
use yii\web\HttpException;

class VendorsGroupBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new VendorGroup();
        $searchModel = new VendorGroupSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        return $this->refresh();
                    }
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
        $model = VendorGroup::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Группа поставщиков не существует');
        }
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->update()) {
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
        if (VendorGroup::findOne($id)->delete()) {
            Alert::setSuccessNotify('Группа поставщиков удалена');
        }

        $this->redirect(['index']);
    }
}