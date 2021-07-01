<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\CompositionType;
use app\modules\catalog\models\search\CompositionSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;
use Yii;
use yii\widgets\ActiveForm;

class CompositionBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\catalog\models\entity\Composition';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new CompositionSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $type = CompositionType::find()->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

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
            'type' => $type,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        $type = CompositionType::find()->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент удален');

        return $this->redirect(['index']);
    }
}