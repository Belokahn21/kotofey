<?php

namespace app\modules\geo\controllers;

use app\modules\site\controllers\MainBackendController;
use Yii;
use app\modules\geo\models\entity\Geo;
use app\modules\geo\models\entity\GeoTimezone;
use app\modules\geo\models\search\GeoSearchForm;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;

class GeoBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Geo();
        $time_zones = GeoTimezone::find()->all();
        $searchModel = new GeoSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Гео объект добавлен');
                        return $this->refresh();
                    }
                }
            }
        }
        return $this->render('index', [
            'model' => $model,
            'time_zones' => $time_zones,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Geo::findOne($id);
        $time_zones = GeoTimezone::find()->all();
        if (!$model) {
            throw new HttpException(404, 'Гео объект не найден');
        }
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Гео объект обновлен');
                        return $this->refresh();
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'time_zones' => $time_zones,
        ]);
    }

    public function actionDelete($id)
    {
        if (Geo::findOne($id)->delete()) {
            Alert::setSuccessNotify('Гео объект удалён');
        }

        return $this->redirect(['index']);
    }
}
