<?php


namespace app\modules\acquiring\controllers;

use app\modules\acquiring\models\search\AcquiringOrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\controllers\MainBackendController;

class AcquiringBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\acquiring\models\entity\AcquiringOrder';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new AcquiringOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());


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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно обновлён.');
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
//        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
//
//        if ($model->delete()) Alert::setSuccessNotify('Элмент успешно удалён');

        return $this->redirect(['index']);
    }
}