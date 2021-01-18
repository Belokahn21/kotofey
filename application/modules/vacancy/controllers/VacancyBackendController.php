<?php

namespace app\modules\vacancy\controllers;

use app\modules\site\controllers\MainBackendController;
use Yii;
use app\modules\geo\models\entity\Geo;
use app\modules\vacancy\models\entity\Vacancy;
use app\modules\vacancy\models\search\VacancySearchForm;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class VacancyBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new Vacancy();
        $searchModel = new VacancySearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $city_list = Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Вакансия успешно добавлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'city_list' => $city_list
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Vacancy::findOne($id);
        $city_list = Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->all();

        if (!$model) {
            throw new HttpException(404, 'Элемент не найден');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Вакансия успешно обновлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'city_list' => $city_list
        ]);
    }

    public function actionDelete($id)
    {
        if (Vacancy::findOne($id)->delete()) {
            Alert::setSuccessNotify('Вакансия удалена');
        }
        return $this->redirect(['index']);
    }
}
