<?php


namespace app\modules\acquiring\models\services\fiscalisation;


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
        $this->api->sendCheck($order, [
            'email' => $email
        ]);
    }

    public function sendCheckClientByPhone(Order $order, string $phone)
    {
        $this->api->sendCheck($order, [
            'phone' => $phone
        ]);
    }
}