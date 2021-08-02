<?php
use app\modules\mailer\models\services\MailService;

$sender = new MailService();

$sender->sendEvent(6, [
    'EMAIL_FROM' => 'sale@kotofey.store',
    'EMAIL_TO' => 'popugau@gmail.com',
    'LINK_SITE' => 'popugau@gmail.com',
    'PROMOCODE' => 'popugau@gmail.com',
    'DISCOUNT' => 'popugau@gmail.com',
]);