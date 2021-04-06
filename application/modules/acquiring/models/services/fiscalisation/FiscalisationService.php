<?php


namespace app\modules\acquiring\models\services\fiscalisation;


use app\modules\acquiring\models\services\fiscalisation\models\OFDApi;

class FiscalisationService
{
    private $api;

    public function __construct()
    {
        $this->api = new OFDApi();
    }

    public function sendCheckClient($email, $phone = null)
    {
        $this->api->sendCheck();
    }
}