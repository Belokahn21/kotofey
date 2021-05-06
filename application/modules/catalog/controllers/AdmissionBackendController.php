<?php

namespace app\modules\catalog\controllers;

use Yii;
use app\widgets\notification\Alert;
use app\modules\catalog\models\entity\NotifyAdmission;
use app\modules\site\controllers\MainBackendController;
use app\modules\catalog\models\search\NotifyAdmissionSearch;

class AdmissionBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new NotifyAdmission();
        $searchModel = new NotifyAdmissionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

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
        return $this->render('update');
    }

    public function actionDelete($id)
    {
    }
}