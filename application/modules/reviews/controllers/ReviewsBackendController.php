<?php

namespace app\modules\reviews\controllers;

use Yii;
use app\widgets\notification\Alert;
use app\modules\reviews\models\entity\Reviews;
use app\modules\reviews\models\search\ReviewsSearch;
use app\modules\site\controllers\MainBackendController;
use yii\web\HttpException;

class ReviewsBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new Reviews();
        $searchModel = new ReviewsSearch();
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
        if (!$model = Reviews::findOne($id)) throw new HttpException(404, 'Элемент не найден');

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
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = Reviews::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Отзыв успешно удален');

        return $this->redirect(['index']);
    }
}
