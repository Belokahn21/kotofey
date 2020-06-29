<?php

namespace app\modules\stock\controllers;

use app\modules\stock\models\entity\Stocks;
use app\modules\stock\models\search\StockSearchForm;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class StockBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Stocks();
        $searchModel = new StockSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->create()) {
                Alert::setSuccessNotify('Склад успешно создан');
                return $this->refresh();
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
        $model = Stocks::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Склад отсутсвует');
        }
        if (\Yii::$app->request->isPost) {
            if ($model->edit()) {
                Alert::setSuccessNotify('Склад успешно обновлен');
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (Stocks::findOne($id)->delete()) {
            Alert::setSuccessNotify('Склад удалён');
        }

        return $this->redirect(['index']);
    }
}
