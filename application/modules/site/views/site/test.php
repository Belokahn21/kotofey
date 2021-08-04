<?php
use app\modules\mailer\models\services\MailService;

$sender = new MailService();

$sender->sendEvent(3, [
    'EMAIL_FROM' => 'sale@kotofey.store',
    'EMAIL_TO' => 'test-zq48ptlip@srv1.mail-tester.com',
]);