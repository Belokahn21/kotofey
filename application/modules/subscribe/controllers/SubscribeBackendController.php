<?php


namespace app\modules\subscribe\controllers;

use Yii;
use app\modules\site\controllers\MainBackendController;
use app\modules\subscribe\models\search\SubscribesSearch;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class SubscribeBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\subscribe\models\entity\Subscribes';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new SubscribesSearch();
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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен.');
                    return $this->refresh();
                }
            }
        }
        return $this->render('update');
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален');

        return $this->redirect(['index']);
    }
}