<?php

namespace app\modules\news\controllers;

use app\modules\news\models\search\NewsSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class NewsBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\news\models\entity\News';

    public function actionIndex()
    {
        $model = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_INSERT]);
        $searchModel = new NewsSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {

                    if ($model->save()) {
                        Alert::setSuccessNotify('Новость успешно создана');
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
        $model = $this->modelClass::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Запись не существует');
        }
        $model->scenario = $this->modelClass::SCENARIO_UPDATE;

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Новость обновлена');
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
        if ($this->modelClass::findOne($id)->delete()) {
            Alert::setSuccessNotify('Новость успешно удалена');
        }

        return $this->redirect(['index']);
    }
}
