<?php

namespace app\modules\mailer\controllers;

use Yii;
use app\widgets\notification\Alert;
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


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Почтовое событие добавлено.');
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
}
