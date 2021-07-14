<?php

use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\mailer\models\services\MailService;

$ns = new \app\modules\order\models\service\NotifyService();
$ns->notifyOrderCreate(\app\modules\order\models\entity\Order::findOne(525));
?>