<?php

namespace app\models\services;


use app\models\helpers\OrderHelper;
use app\modules\order\models\entity\Order;
use app\models\entity\OrderDate;
use app\modules\order\models\entity\OrdersItems;
use app\models\entity\User;
use app\models\entity\user\Billing;
use app\models\tool\Price;
use app\models\tool\statistic\OrderStatistic;
use VK\Client\VKApiClient;
use Yii;
use yii\helpers\Url;

class NotifyService
{
	public function sendMessageToVkontakte($order_id, $access_token = null)
	{
		try {

			$access_token = '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674';
			$vk = new VKApiClient();
			if ($access_token) {
				$order = Order::findOne($order_id);
				$orderSumm = OrderHelper::orderSummary($order->id);
				$orderDateDelivery = OrderDate::findOne(['order_id' => $order->id]);
				$detailUrlPage = Url::to(['/admin/order/order-backend/update', 'id' => $order->id], true);

				if (!$order) {
					return false;
				}

				$message = "Новый заказ на сайте {$_SERVER['SERVER_NAME']}\n
				Сумма заказа: {$orderSumm}\n\n";

				$message .= "Клиент:\n";
				if (!empty($order->phone)) {
					$message .= "Телефон: {$order->phone}";
				}

				if (!empty($order->email)) {
					$message .= "Email: {$order->email}";
				}

				$message .= "\n\n";

				if ($orderDateDelivery) {
					$message .= "Дата доставки {$orderDateDelivery->date}, время: {$orderDateDelivery->time}\n\n";
				}


				/* @var $item OrdersItems */
				foreach (OrdersItems::find()->where(['order_id' => $order->id])->all() as $item) {
					$message .= "{$item->count}шт . {$item->name}\n";
				}
				$message .= "\n";

				$message .= "Подробнее {$detailUrlPage}\n";


				$message_response = $vk->messages()->send($access_token, [
					'user_id' => Yii::$app->params['vk']['adminVkontakteId'],
					'random_id' => rand(1, 999999),
					'peer_id' => Yii::$app->params['vk']['adminVkontakteId'],
					'message' => $message,
				]);

			}
		} catch (\Exception $exception) {
		}
	}

	public
	function sendEmailClient(
		$order_id = 1
	) {
		if (YII_ENV == 'dev') {
			return false;
		}
		$order = Order::findOne($order_id);
		if (!$order) {
			return false;
		}

		$client = User::findOne($order->user_id);

		$result = Yii::$app->mailer->compose('client-buy', [
			'order' => $order,
			'order_items' => OrdersItems::find()->where(['order_id' => $order_id])->all()
		])
			->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
			->setTo($client->email)
			->setSubject('Квитанция о покупке - спасибо, что вы с нами!')
			->send();

		return $result;
	}
}