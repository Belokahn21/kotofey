<?php


namespace app\modules\mailer\controllers;

use Yii;
use app\widgets\notification\Alert;
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


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Почтовый шаблон добавлен.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'events' => $events,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}