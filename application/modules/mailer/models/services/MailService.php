<?php


namespace app\modules\mailer\models\services;

use Yii;
use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\entity\MailTemplates;
use app\modules\order\models\entity\OrdersItems;

class MailService
{
    public function sendEvent(int $event_id)
    {
        if (!$event = MailEvents::findOne($event_id)) throw new \Exception("События с ID = $event_id не существует");

        if (!$messages = MailTemplates::find()->where(['event_id' => $event_id])->all()) throw new \Exception('Сообщений нет к событию #' . $event_id);

        foreach ($messages as $message) {
            $result = Yii::$app->mailer->compose();
            $result->setHtmlBody($message->text);

//                ->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
//                ->setTo($order->email)
//                ->setSubject('Квитанция о покупке - спасибо, что вы с нами!')
//                ->send();
        }
    }
}