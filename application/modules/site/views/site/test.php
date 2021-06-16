<?php

use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\mailer\models\services\MailService;

$event = \app\modules\mailer\models\entity\MailEvents::findOne(2);
if (!$event) return false;

$mails = \app\modules\mailer\models\entity\MailTemplates::findAll(['event_id' => $event->id]);

foreach ($mails as $mail) {
    \app\modules\site\models\tools\Debug::p($mail);



    $mailer = new MailService();
    $mailer->sendEvent($event->id, [
        'EMAIL_FROM' => 'sale@kotofey.store',
        'EMAIL_TO' => 'popugau@gmail.com',
    ]);
}
?>