<?php

namespace app\modules\order\models\events;

use app\modules\order\models\service\NotifyService;

class OrderEvents
{
	public static function noticeAboutCreateOrder($event)
	{
		// создаётся в группе ВК
		$notify_service = new NotifyService();
		$notify_service->sendMessageToVkontakte($event->data['order_id'], '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674');
//		$notify_service->sendEmailClient($event->data['order_id']);
		return true;
	}
}