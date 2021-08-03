<?php

namespace app\modules\mailer\controllers;

use app\modules\mailer\models\search\MailHistorySearch;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class HistoryBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\mailer\models\entity\MailHistory';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new MailHistorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден');
    }

    public function actionDelete($id)
    {
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден');
        if ($model->delete()) Alert::setSuccessNotify('Элемент удален');
        return $this->redirect(['index']);
    }

    private function getModel($primaryKey)
    {
        return $this->modelClass::findOne($primaryKey);
    }
}