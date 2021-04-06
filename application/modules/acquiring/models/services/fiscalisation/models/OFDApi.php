<?php

namespace app\modules\acquiring\models\services\fiscalisation\models;

use app\modules\acquiring\Module;
use app\modules\order\models\entity\Order;
use app\modules\site\models\helpers\ModuleSettingsHelper;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class OFDApi
{
    private $ofd_token;
    private $module;

    const MODULE_ID = 'acquiring';

    const URL = 'https://ferma.ofd.ru/api/kkt/cloud/';
    const DEMO_URL = 'https://ferma-test.ofd.ru/api/kkt/cloud/';
    const ACTION_CREATE_CHECK = 'receipt';

    /**
     * @property Module @module
     */
    public function __construct()
    {

        $this->getModule();

        if (empty($this->module->ofd_login) || empty($this->module->ofd_password)) throw new \Exception('Нет авторизационных данных для получения токена.');

        $this->ofd_token = new OFDAuth($this->module->ofd_login, $this->module->ofd_password);
    }

    public function sendCheck(Order $order, $userData = [])
    {

        $items = $order->items;

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
                'CustomUserProperty' => [
//                    'AutomatNumber' => "123456",
                    'BillAddress' => "Барнаул, ул. Северо-Западная, 6Б",
                ],

            ],
        ];

        $paramsItems = [];
        foreach ($items as $item) {
            $paramsItems[] = [
                "Label" => $item->name,
                "Price" => $item->price,
                "Quantity" => $item->count,
                "Amount" => $item->price * $item->count,
                "Vat" => "Vat0",
//                "MarkingCode" => "000559D39E7F197241424331323334",
//                "MarkingCodeStructured" => [
//                    "Type" => "MEDICINES",
//                    "Gtin" => "77777777777777",
//                    "Serial" => "RXWWWRRRRRRRR"
//                ],
                "PaymentMethod" => 4,
//                "OriginCountryCode" => "398",
//                "CustomsDeclarationNumber" => "ТаможняДала Добро №1/#15",
                "PaymentType" => 1,
                "PaymentAgentInfo" => [
                    "AgentType" => "BANK_PAYMENT_AGENT",
                    "TransferAgentPhone" => "+79000000001",
                    "TransferAgentName" => "наименование оператора перевода",
                    "TransferAgentAddress" => "адрес оператора перевода",
                    "TransferAgentINN" => "1234567890",
                    "PaymentAgentOperation" => "операция платежного агента",
                    "PaymentAgentPhone" => "+79000000002",
                    "ReceiverPhone" => "+79000000003",
                    "SupplierInn" => "012345678901",
                    "SupplierName" => "Иван Иванов",
                    "SupplierPhone" => "+79000000004"
                ],
                'Cashier' => [
                    "Name" => "Васин Константин Викторович",
                    "Inn" => "991133557"
                ]
            ];
        }

        $params['Items'] = $paramsItems;

        $response = $this->send(self::ACTION_CREATE_CHECK, $params);

        Debug::p($response);
    }

    public function send($action, $data = [], $headers = [])
    {
        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, self::DEMO_URL . $action);
//            curl_setopt($curl, CURLOPT_URL, self::URL . $action);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);


            $finish_headers = [
                'Content-Type: application/json;charset=utf-8 ',
            ];
            if ($headers) $finish_headers = array_merge($finish_headers, $headers);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $finish_headers);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($data));


            $response = curl_exec($curl);
            curl_close($curl);
        }

        return $response;
    }

    public function getModule()
    {
        if (!\Yii::$app->hasModule(self::MODULE_ID)) throw new \Exception('Модуль эквайринга не подключен.');

        $this->module = \Yii::$app->getModule(self::MODULE_ID);
    }
}