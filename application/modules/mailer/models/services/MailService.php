<?php


namespace app\modules\mailer\models\services;

use Yii;
use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\entity\MailTemplates;

class MailService
{
    public function sendEvent(int $event_id, $params = [])
    {
        if (!$event = MailEvents::findOne($event_id)) throw new \Exception("События с ID = $event_id не существует");

        if (!$messages = MailTemplates::find()->where(['event_id' => $event_id])->all()) throw new \Exception('Сообщений нет к событию #' . $event_id);

        foreach ($messages as $message) {
            $result = Yii::$app->mailer->compose();
            $result->setHtmlBody($this->replaceValues($message->text, $params));
            $result->setFrom([$this->replaceValues($message->from, $params) => 'Зоомагазин Котофей']);
            $result->setTo($this->replaceValues($message->to, $params));
            $result->setSubject($this->replaceValues($message->name, $params));

            $result->setBcc('popugau@gmail.com');

            $result->send();
        }
    }

    private function replaceValues(string $string, array $values)
    {
        foreach ($values as $k => $v) {
            $string = str_replace("#{$k}#", $values[$k], $string);
        }

        return $string;
    }
}