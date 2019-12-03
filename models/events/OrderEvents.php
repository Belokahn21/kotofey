<?php

namespace app\models\events;

use app\models\entity\Order;
use app\models\entity\User;
use app\models\entity\user\Billing;
use app\models\tool\Price;
use app\models\tool\statistic\OrderStatistic;
use Yii;
use VK\Client\VKApiClient;

class OrderEvents
{
	public static function noticeAboutCreateOrder($event)
	{
		// создаётся в группе ВК
		$access_token = '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674';
		$vk = new VKApiClient();
		if ($access_token) {

			$order_id = $event->data['order_id'];
			$Client = User::findOne(Order::findOne($order_id)->user_id);
			$ClientBilling = Billing::findByUser($Client->id);
			$delivery_info = "";


			if ($ClientBilling) {
				foreach (['city', 'street', 'home', 'house'] as $key) {
					$delivery_info .= $ClientBilling->getAttributeLabel($key) . ': ' . $ClientBilling->{$key} . ', ';
				}
			}

			$message_response = $vk->messages()->send($access_token, [
				'user_id' => Yii::$app->params['vk']['adminVkontakteId'],
				'random_id' => rand(1, 999999),
				'peer_id' => Yii::$app->params['vk']['adminVkontakteId'],
				'message' => sprintf("Новый заказ на сумму: %sр.\n
				Информация о клиенте:
				- Email: %s
				- Телефон: %s\n
				Доставка: %s\n
				Подробнее: https://kotofey.store/admin/order/%d/",
					Price::format(OrderStatistic::orderSummary($order_id)), $Client->email, $Client->phone, substr($delivery_info, 0, -2), $order_id),
			]);

		}

		return true;
	}
}