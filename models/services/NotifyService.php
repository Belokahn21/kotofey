<?php

namespace app\models\services;


use app\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\User;
use app\models\entity\user\Billing;
use app\models\tool\Price;
use app\models\tool\statistic\OrderStatistic;
use VK\Client\VKApiClient;
use Yii;

class NotifyService
{
	public function sendMessageToVkontakte($order_id, $access_token)
	{
		$access_token = '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674';
		$vk = new VKApiClient();
		if ($access_token) {
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
	}

	public function sendEmailClient($order_id)
	{

//		$order = Order::findOne($order_id);
//		if (!$order) {
//			return false;
//		}

//		$client = User::findOne($order->user_id);

		$result = Yii::$app->mailer->compose('client-buy', [
			'order_items' => OrdersItems::find()->where(['order_id' => $order_id])->all()
		])
			->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
			->setTo('popugau@gmail.com')
//			->setTo($client->email)
			->setSubject('Квитанция о покупке - спасибо, что вы с нами!')
			->send();

		var_dump($result);
		return $result;
	}
}