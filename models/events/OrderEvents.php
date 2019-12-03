<?php

namespace app\models\events;

use Yii;
use VK\Client\VKApiClient;

class OrderEvents
{
	public static function noticeAboutCreateOrder($event)
	{
		$access_token = '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674';
		$vk = new VKApiClient();
		if ($access_token) {

			$message_response = $vk->messages()->send($access_token, [
				'user_id' => Yii::$app->params['vk']['adminVkontakteId'],
				'random_id' => rand(1, 999999),
				'peer_id' => Yii::$app->params['vk']['adminVkontakteId'],
				'message' => 'Новый заказ <br />Подробнее: https://kotofey.store/admin/orders/' . $event->data['order_id'] . '',

			]);

		}

		return true;
	}
}