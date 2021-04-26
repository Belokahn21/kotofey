<?php

namespace app\modules\mailer\controllers;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\search\MailEventsSearch;
use app\modules\site\controllers\MainBackendController;

class EventsBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new MailEvents();
        $searchModel = new MailEventsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
