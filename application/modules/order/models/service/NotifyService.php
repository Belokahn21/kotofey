<?php

namespace app\modules\order\models\service;


use app\modules\order\models\entity\OrderMailHistory;
use app\modules\site\models\tools\System;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\mailer\models\services\MailService;
use app\modules\mailer\models\entity\MailTemplates;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\entity\OrdersItems;
use app\modules\mailer\models\entity\MailEvents;
use app\modules\order\models\entity\OrderDate;
use app\modules\site\models\forms\GrumingForm;
use app\modules\site\models\tools\Currency;
use app\modules\order\models\entity\Order;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Price;
use app\modules\stock\models\entity\Stocks;
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
                $orderSumm = OrderHelper::orderSummary($order);
                $orderSumm = Price::format($orderSumm) . Currency::getInstance()->show();
                $orderDateDelivery = OrderDate::findOne(['order_id' => $order->id]);
                $detailUrlPage = Url::to(['/admin/order/order-backend/update', 'id' => $order->id], true);

                if (!$order) {
                    return false;
                }

                $message = "Новый заказ на сайте {$_SERVER['SERVER_NAME']}\n
				Сумма заказа: {$orderSumm}\n\n";

                $message .= "Клиент:\n";

                if (!empty($order->phone)) $message .= "Телефон: {$order->phone}\n";
                if (!empty($order->email)) $message .= "Email: {$order->email}\n\n";
                $message .= "Оплата: " . OrderHelper::getPayment($order) . "\n";
                $message .= "Доставка: " . OrderHelper::getDelivery($order) . "\n";

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


                foreach (Yii::$app->params['vk']['adminVkontakteId'] as $vk_id) {
                    $message_response = $vk->messages()->send($access_token, [
                        'user_id' => $vk_id,
                        'random_id' => rand(1, 999999),
                        'peer_id' => $vk_id,
                        'message' => $message,
                    ]);
                }

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

        if (!$order or empty($order->email)) return false;

        $result = Yii::$app->mailer->compose('client-buy', [
            'order' => $order,
            'order_items' => OrdersItems::find()->where(['order_id' => $order_id])->all()
        ])
            ->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
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

    public function notifyCompleteOrder(Order $order)
    {
        if (!$module = Yii::$app->getModule('order')) return false;
        if (!$event = MailEvents::findOne($module->mail_event_id_order_ready)) return false;

        if (OrderMailHistory::findOne(['order_id' => $order->id, 'event_id' => $event->id])) return false;

        if (empty($order->email) || $order->status != 8) return false;

        $stock = Stocks::findOne(1);

        $mailer = new MailService();
        $mailer->sendEvent($event->id, [
            'EMAIL_FROM' => 'sale@kotofey.store',
            'EMAIL_TO' => $order->email,
            'ORDER_ID' => $order->id,
            'ORDER_LINK' => System::fullSiteUrl() . "/profile/order/{$order->id}/",
            'STORE_ADDRESS' => $stock->address,
            'STORE_TIME' => "{$stock->time_start} до {$stock->time_end}",
            'DELIVERY_DATE' => $order->dateDelivery->date,
            'DELIVERY_TIME' => $order->dateDelivery->time,
            'LINK_CAT' => System::fullSiteUrl() . '/catalog/koski/',
            'LINK_DOG' => System::fullSiteUrl() . '/catalog/sobaki/',
            'LINK_MOUSE' => System::fullSiteUrl() . '/catalog/gryzuny/',
            'LINK_FISH' => System::fullSiteUrl() . '/catalog/rybki/',
        ]);

        $history = new OrderMailHistory();
        $history->order_id = $order->id;
        $history->event_id = $event->id;
        return $history->validate() && $history->save();
    }

    public function notifyOrderCreate(Order $order)
    {
        if (!$module = Yii::$app->getModule('order')) return false;
        if (!$event = MailEvents::findOne($module->mail_event_id_order_created)) return false;

        if (OrderMailHistory::findOne(['order_id' => $order->id, 'event_id' => $event->id])) return false;

        if (empty($order->email)) return false;
        if (empty($order->email) || $order->status != 0) return false;

        $mailer = new MailService();
        $mailer->sendEvent($event->id, [
            'EMAIL_FROM' => 'sale@kotofey.store',
            'EMAIL_TO' => $order->email,
//            'EMAIL_TO' => 'popugau@gmail.com',
            'ORDER_ID' => $order->id,
            'ORDER_LINK' => System::fullSiteUrl() . "/profile/order/{$order->id}/",
            'SITE_LINK' => System::fullSiteUrl(),
            'SITE_NAME' => 'Интернет-зоомагазин Котофей',
            'ORDER_ITEMS' => call_user_func(function () use ($order) {
                /* @var $order Order */
                $html = '<tr style="background-color: #e6e6e6;"><td width="55%" style="text-align:left; padding: 5px;">Наименование</td><td style="padding: 5px;" width="15%">Количество</td><td style="padding: 5px;" width="15%">Цена за шт.</td><td style="padding: 5px;" width="15%">Итого</td></tr>';
                $total = 0;
                foreach ($order->items as $item) {
                    $price = Price::format($item->price);
                    $summ = Price::format($item->price * $item->count);
                    $currency = Currency::getInstance()->show();

                    $total += $item->price * $item->count;

                    $html .= "<tr><td style='text-align:left; padding: 5px;'>{$item->name}</td><td style='padding: 5px;'>{$item->count}</td><td style='padding: 5px;'>{$price}{$currency}</td><td style='padding: 5px;'>{$summ}{$currency}</td></tr>";
                }

//                $html .= "<tr style='background-color: #e6e6e6;'><td style='text-align:left; padding: 5px;'>Доставка заказа {$order->dateDelivery->date}, время {$order->dateDelivery->date}</td><td style='text-align:center; padding: 5px;' colspan='2'>Итого к оплате</td><td>" . Price::format($total) . "{$currency}</td></tr>";

                return $html;
            }),
        ]);


        $history = new OrderMailHistory();
        $history->order_id = $order->id;
        $history->event_id = $event->id;
        return $history->validate() && $history->save();
    }

    public function sendClientNotify(Order $order)
    {
        $this->notifyCompleteOrder($order);
        $this->notifyOrderCreate($order);
    }
}