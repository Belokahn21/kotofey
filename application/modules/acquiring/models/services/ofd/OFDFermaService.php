<?php

namespace app\modules\acquiring\models\services\ofd;

use app\modules\acquiring\models\services\check_history\ServiceCheckHistory;
use app\modules\acquiring\models\services\ofd\models\OFDApi;
use app\modules\acquiring\models\services\ofd\models\OFDApiDemo;
use app\modules\logger\models\service\LogService;
use app\modules\order\models\entity\Order;

class OFDFermaService
{
    private $api;
    private $module;

    public function __construct()
    {
        $this->module = \Yii::$app->getModule('acquiring');

        if ($this->module->ofd_mode != 'on') return false;

        if (YII_ENV == 'dev') {
            $this->api = new OFDApiDemo();
        } elseif (YII_ENV == 'prod') {
            $this->api = new OFDApi();
        } else {
            throw new \Exception('API фискализации не найдено.');
        }
    }

    public static function getInstance()
    {
        return new OFDFermaService();
    }

    public function sendCheckClientByEmail(Order $order, string $email)
    {
        // Чеки отправляются только оплаченым заказам.
        if (!$order->is_paid) return false;

        // Нет ли старых записей
        if (ServiceCheckHistory::hasCheckHistory($order->id)) return false;

        try {
            $check_id = $this->api->sendCheck($order, [
                'email' => $email
            ]);

            ServiceCheckHistory::saveCheckHistory($order->id, $check_id);


        } catch (\Exception $e) {
            LogService::saveErrorMessage("Ошибка отправки чека покупателю. Заказ: #{$order->id}. Сообщение: " . $e->getMessage(), 'acquiring');
            //todo: оповестить Администратора?
        }
    }

    public function sendCheckClientByPhone(Order $order, string $phone)
    {
        $this->api->sendCheck($order, [
            'phone' => $phone
        ]);
    }

    public function getCheckStatusByOrderId(int $order_id)
    {
        return $this->api->statusCheckByOrderId($order_id);
    }

    public function getCheckStatusByCheckId(string $check_id)
    {
        return $this->api->statusCheckByCheckId($check_id);
    }
}