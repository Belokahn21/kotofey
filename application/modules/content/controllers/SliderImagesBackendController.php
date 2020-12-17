<?php

namespace app\modules\content\controllers;


use app\modules\content\models\entity\SlidersImages;
use app\modules\content\models\search\SlidersImagesSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class SliderImagesBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new SlidersImages();
        $searchModel = new SlidersImagesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Изображение успешно добавлено');
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
        if (!$model = SlidersImages::findOne($id)) {
            throw new HttpException(404, 'Такой записи не существует');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Изображение успешно добавлено');
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
        if (SlidersImages::findOne($id)->delete()) {
            Alert::setSuccessNotify("Изображение успешно удалено");
        }
        return $this->redirect('index');
    }
}