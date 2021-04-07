<?php

namespace app\modules\acquiring\models\services\fiscalisation;

use app\modules\acquiring\models\services\check_history\ServiceCheckHistory;
use app\modules\acquiring\models\services\fiscalisation\models\OFDApi;
use app\modules\order\models\entity\Order;

class FiscalisationService
{
    private $api;

    public function __construct()
    {
        $this->api = new OFDApi();
    }

    public function sendCheckClientByEmail(Order $order, string $email)
    {
        // Чеки отправляются только оплаченым и закрытым заказам.
        if (!$order->is_paid) return false;

        // Нет ли старых записей
        if (ServiceCheckHistory::hasCheckHistory($order->id)) return false;

        try {
            $check_id = $this->api->sendCheck($order, [
                'email' => $email
            ]);

            ServiceCheckHistory::saveCheckHistory($order->id, $check_id);


        } catch (\Exception $e) {
            //todo: оповестить Администратора?
        }
    }

    public function sendCheckClientByPhone(Order $order, string $phone)
    {
        $this->api->sendCheck($order, [
            'phone' => $phone
        ]);
    }
}