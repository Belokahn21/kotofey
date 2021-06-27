<?php

namespace app\modules\vendors\controllers;

use app\modules\vendors\models\entity\Vendor;
use app\modules\vendors\models\search\VendorManagerSearchForm;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\controllers\MainBackendController;
use app\modules\vendors\models\entity\VendorManager;

class VendorManagerBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new VendorManager();
        $vendors = Vendor::find()->all();
        $searchModel = new VendorManagerSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'vendors' => $vendors,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = VendorManager::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        return $this->render('update');
    }

    public function actionDelete($id)
    {
        if (!$model = VendorManager::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален.');

        return $this->redirect(['index']);
    }
}