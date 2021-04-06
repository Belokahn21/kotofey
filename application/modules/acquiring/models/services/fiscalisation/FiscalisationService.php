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

    public function sendCheckClient(Order $order, $email, $phone = null)
    {
        $this->api->sendCheck($order, [
            'email' => $email
        ]);
    }
}