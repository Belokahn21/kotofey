<?php

namespace app\models\events;

use app\models\entity\Order;
use app\models\entity\User;
use app\models\entity\user\Billing;
use app\models\services\NotifyService;
use app\models\tool\Price;
use app\models\tool\statistic\OrderStatistic;
use Yii;
use VK\Client\VKApiClient;

class OrderEvents
{
	public static function noticeAboutCreateOrder($event)
	{
		// создаётся в группе ВК
		$notify_service = new NotifyService();
		$notify_service->sendMessageToVkontakte($event->data['order_id'], '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674');
		$notify_service->sendEmailClient($event->data['order_id']);
		return true;
	}
}