<?php

namespace app\modules\order\models\service;


use app\models\tool\Debug;
use app\modules\site\models\forms\GrumingForm;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderDate;
use app\modules\order\models\entity\OrdersItems;
use app\modules\user\models\entity\User;
use app\modules\user\models\entity\Billing;
use app\models\tool\Price;
use app\models\tool\statistic\OrderStatistic;
use VK\Client\VKApiClient;
use Yii;
use yii\helpers\Url;

class NotifyService
{
    public $accessToken;

    public function sendMessageToVkontakte($order_id, $access_token = null)
    {
        try {
            $this->getAccessToken();
            $access_token = $this->accessToken;
            $vk = new VKApiClient();
            if ($access_token) {
                $order = Order::findOne($order_id);
                $orderSumm = OrderHelper::orderSummary($order->id);
                $orderSumm = Price::format($orderSumm);
                $orderDateDelivery = OrderDate::findOne(['order_id' => $order->id]);
                $detailUrlPage = Url::to(['/admin/order/order-backend/update', 'id' => $order->id], true);

                if (!$order) {
                    return false;
                }

                $message = "Новый заказ на сайте {$_SERVER['SERVER_NAME']}\n
				Сумма заказа: {$orderSumm}\n\n";

                $message .= "Клиент:\n";
                if (!empty($order->phone)) {
                    $message .= "Телефон: {$order->phone}\n";
                }

                if (!empty($order->email)) {
                    $message .= "Email: {$order->email}";
                }

                $message .= "\n\n";
                if (!empty($order->comment)) {
                    $message .= "Комментарий: " . $order->comment;
                    $message .= "\n\n";
                }

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

    public function sendVKAboutGruming(GrumingForm $data)
    {
        try {
            $access_token = "73f1b177f3682882ca6cf3ea633232c236eda2dd1a05bf1f0af9072479aded9e53643c1f8f7856cb21863";
            $vk = new VKApiClient();
            if ($access_token) {

                $message = "Заказ услуг на груминг\n";
                $message .= "Клиент: " . $data->client . "\n";
                $message .= "Телефон: " . $data->phone . "\n";
                $message .= "Услуга: " . $data->service . "\n";
                $message .= "Для питомца: " . $data->pet . "\n";
                $message .= "На дату: " . $data->date;


                $message_response = $vk->messages()->send($access_token, [
                    'user_id' => Yii::$app->params['vk']['grumingVkontakteId'],
                    'random_id' => rand(1, 999999),
                    'peer_id' => Yii::$app->params['vk']['grumingVkontakteId'],
                    'message' => $message,
                ]);

                $this->getAccessToken();

                $message_response2 = $vk->messages()->send($this->accessToken, [
                    'user_id' => Yii::$app->params['vk']['adminVkontakteId'],
                    'random_id' => rand(1, 999999),
                    'peer_id' => Yii::$app->params['vk']['adminVkontakteId'],
                    'message' => $message,
                ]);

                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }

        return false;
    }

    public function sendEmailClient($order_id)
    {
        $order = Order::findOne($order_id);

        if (!$order or empty($order->email)) {
            return false;
        }


        $result = Yii::$app->mailer->compose('client-buy', [
            'order' => $order,
            'order_items' => OrdersItems::find()->where(['order_id' => $order_id])->all()
        ])
            ->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
//			->setTo('popugau@gmail.com')
            ->setTo($order->email)
            ->setSubject('Квитанция о покупке - спасибо, что вы с нами!')
            ->send();

        return $result;
    }

    public function getAccessToken()
    {
        $token = Yii::$app->params['vk']['access_token'];

        if ($tokenFromSettings = SiteSettings::findByCode('vk_access_token')) {
            $token = $token->value;
        }

        $this->accessToken = $token;
    }
}