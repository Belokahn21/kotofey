<?php

namespace app\modules\mailer\controllers;

use app\modules\mailer\models\entity\MailHistory;
use app\modules\mailer\models\search\MailHistorySearch;
use app\modules\site\controllers\MainBackendController;

class HistoryBackendController extends MainBackendController
{
    public $modelClass = '';

    public function actionIndex()
    {
        $model = new MailHistory();
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
    }

    public function actionDelete($id)
    {
    }
}