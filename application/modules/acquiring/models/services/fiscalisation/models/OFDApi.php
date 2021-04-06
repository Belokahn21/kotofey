<?php

namespace app\modules\acquiring\models\services\fiscalisation\models;

use app\modules\order\models\entity\Order;
use app\modules\site\models\helpers\ModuleSettingsHelper;
use yii\helpers\Json;

class OFDApi
{
    private $ofd_token;
    const URL = 'https://ferma.ofd.ru/api/kkt/cloud/';
    const ACTION_CREATE_CHECK = 'receipt';

    public function __construct()
    {
        $this->ofd_token = new OFDAuth(ModuleSettingsHelper::getValue('acquiring', 'inn'), ModuleSettingsHelper::getValue('acquiring', 'inn'));
    }

    public function sendCheck(Order $order, $userData = [])
    {
        $params = [
            'Inn' => ModuleSettingsHelper::getValue('acquiring', 'inn'),
            'Type' => 'income',
            'InvoiceId' => $order->id,
            'LocalDate' => date('d.m.Y H:i:s', $order->created_at),
            'CustomerReceipt' => [
                'TaxationSystem' => 'VatNo',
                'Email' => $userData['email'],
                'PaymentType' => 'VatNo',
                'KktFA' => true,
            ],
        ];

        $this->send(self::ACTION_CREATE_CHECK, $params);
    }

    public function send($action, $data = [], $headers = [])
    {
        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, self::URL . $action);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));


            $response = curl_exec($curl);
            curl_close($curl);
        }

        return $response;
    }
}