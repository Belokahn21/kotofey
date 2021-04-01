<?php

namespace app\modules\site_settings\controllers;

use Yii;
use app\modules\site\controllers\MainBackendController;
use app\modules\site_settings\models\search\SettingsSearchForm;
use app\widgets\notification\Alert;

class SettingsBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\site_settings\models\entity\SiteSettings';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new SettingsSearchForm();
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
        $model = $this->modelClass::findOne($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен.');
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
        if ($model = $this->modelClass::findOne($id)) {
            if ($model->delete()) {
                Alert::setSuccessNotify('Элемент успешно удален');
            }
        }

        return $this->redirect(['index']);
    }
}
