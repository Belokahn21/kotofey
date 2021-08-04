<?php


namespace app\modules\mailer\models\services;

use app\modules\mailer\Module;
use Yii;
use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\entity\MailTemplates;

class MailService
{
    public function sendEvent(int $event_id, $params = [])
    {
        if (!$event = MailEvents::findOne($event_id)) throw new \Exception("События с ID = $event_id не существует");

        if (!$messages = MailTemplates::find()->where(['event_id' => $event_id])->all()) throw new \Exception('Сообщений нет к событию #' . $event_id);

        /* @var $module Module */
        $module = Yii::$app->getModule('mailer');

        $dkim_private_key = $module->dkim_private_key;
        $dkim_domain = $module->dkim_domain;
        $dkim_selector = $module->dkim_selector;

        foreach ($messages as $message) {

            $mailer = Yii::$app->mailer->compose();
            $mailer->setHtmlBody($this->replaceValues($message->text, $params));
            $mailer->setFrom([$this->replaceValues($message->from, $params) => 'Зоомагазин Котофей']);
            $mailer->setTo($this->replaceValues($message->to, $params));
            $mailer->setSubject($this->replaceValues($message->name, $params));

            $mailer->setBcc('popugau@gmail.com');

//            if (!empty($dkim_private_key) && !empty($dkim_domain) && !empty($dkim_selector)) {
//                $signer = new \Swift_Signers_DKIMSigner(file_get_contents($dkim_private_key), $dkim_domain, $dkim_selector);
//                $mailer->getSwiftMessage()->attachSigner($signer);
//            }

            $mailer->send();
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