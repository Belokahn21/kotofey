<?php


namespace app\modules\mailer\controllers;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\entity\MailTemplates;
use app\modules\mailer\models\search\MailTemplatesSearch;
use app\modules\site\controllers\MainBackendController;

class TemplatesBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new MailTemplates();
        $searchModel = new MailTemplatesSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        $events = MailEvents::find()->all();

        return $this->render('index', [
            'model' => $model,
            'events' => $events,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}