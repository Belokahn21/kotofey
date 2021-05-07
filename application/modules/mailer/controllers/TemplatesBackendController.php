<?php


namespace app\modules\mailer\controllers;

use Yii;
use app\widgets\notification\Alert;
use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\entity\MailTemplates;
use app\modules\mailer\models\search\MailTemplatesSearch;
use app\modules\site\controllers\MainBackendController;
use yii\web\HttpException;

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

    public function actionUpdate($id)
    {
        if (!$model = MailTemplates::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        $events = MailEvents::find()->all();


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Почтовый шаблон добавлен.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'events' => $events,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = MailTemplates::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален');
        return $this->redirect(['index']);
    }
}