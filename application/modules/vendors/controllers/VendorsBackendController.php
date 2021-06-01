<?php

namespace app\modules\vendors\controllers;

use app\modules\site\controllers\MainBackendController;
use app\modules\vendors\models\search\VendorSearchForm;
use app\widgets\notification\Alert;
use Yii;
use app\modules\vendors\models\entity\Vendor;
use yii\web\HttpException;

class VendorsBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Vendor();
        $searchModel = new VendorSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
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
        $model = Vendor::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Поставщик не существует');
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
        if (Vendor::findOne($id)->delete()) {
            Alert::setSuccessNotify('Поставщик удалён');
        }

        return $this->redirect(['index']);
    }
}
