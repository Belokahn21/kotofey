<?php

namespace app\modules\mailer\controllers;

use Yii;
use app\widgets\notification\Alert;
use app\modules\mailer\models\search\MailEventsSearch;
use app\modules\site\controllers\MainBackendController;
use yii\web\HttpException;

class EventsBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\mailer\models\entity\MailEvents';

    public function actionIndex()
    {
        $model = new $this->modelClass();
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

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Почтовое событие обновлено.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        if ($model->delete()) Alert::setSuccessNotify("Почтовое событие {$model->name} успешно удалено");
        return $this->redirect(['index']);
    }
}
