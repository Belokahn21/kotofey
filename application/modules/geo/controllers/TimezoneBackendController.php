<?php

namespace app\modules\geo\controllers;

use app\modules\site\controllers\MainBackendController;
use Yii;
use app\modules\geo\models\entity\GeoTimezone;
use app\modules\geo\models\search\GeoTimezoneSearch;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class TimezoneBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new GeoTimezone();
        $searchModel = new GeoTimezoneSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Временая зона успешно добвлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = GeoTimezone::findOne($id);

        if (!$model) {
            throw new HttpException(404, 'Элемент не найден');
        }


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Временая зона успешно обновлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (GeoTimezone::findOne($id)->delete()) {
            Alert::setSuccessNotify('Временная зона удалена');
        }
        return $this->redirect(['index']);
    }
}