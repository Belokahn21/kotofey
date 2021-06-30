<?php

namespace app\modules\subscribe\controllers;

use app\modules\logger\models\service\LogService;
use app\modules\site\models\tools\Debug;
use app\modules\subscribe\models\entity\Subscribes;
use app\widgets\notification\Alert;
use yii\web\Controller;

class UnsubscribeController extends Controller
{
    public function actionIndex($email)
    {
        if (!$model = Subscribes::findOne(['email' => $email])) {
            $model = new Subscribes();
            $model->email = $email;
            $model->active = 0;
            if (!$model->validate() || !$model->save()) {
                LogService::saveErrorMessage(Debug::modelErrors($model), 'unsubscribe');
                Alert::setErrorNotify("Отписаться не удалось из-за непредвиденной ошибки. Мы сообщим вам на {$email}, когда решится вопрос!");
                return $this->redirect(['/']);
            }
        }


        $model->active = 0;
        if (!$model->validate() || $model->update() === false) {
            LogService::saveErrorMessage(Debug::modelErrors($model), 'unsubscribe');
            Alert::setErrorNotify("Отписаться не удалось из-за непредвиденной ошибки. Мы сообщим вам на {$email}, когда решится вопрос!");
            return $this->redirect(['/']);
        }

        Alert::setSuccessNotify('Вы успешно отписались от нас!');
        return $this->redirect(['/']);
    }
}