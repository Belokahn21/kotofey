<?php

namespace app\modules\catalog\controllers;


use app\models\entity\Informers;
use app\models\search\InformersSearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;

class ProductInformerBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Informers();
        $searchModel = new InformersSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {

                    if ($model->save()) {
                        Alert::setSuccessNotify('Справочник добавлен');
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
        $model = Informers::findOne($id);
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {

                    if ($model->update()) {
                        Alert::setSuccessNotify('Справочник обновлён');
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
        if (Informers::findOne($id)->delete()) {
            Alert::setSuccessNotify('Справочник удалён');
        }

        return $this->redirect(['index']);
    }
}