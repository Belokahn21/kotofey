<?php

namespace app\modules\acquiring\models\services\fiscalisation\models;

use app\modules\acquiring\Module;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\helpers\ModuleSettingsHelper;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\System;
use yii\helpers\Json;

/**
 * @property string $ofd_token
 * @property Module $module
 */
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

        $this->ofd_token = (new OFDAuth($this->module->ofd_login, $this->module->ofd_password))->getToken();
    }

    public function sendCheck(Order $order, $userData = [])
    {
        $items = $order->items;

        $params = [
            'Inn' => $this->module->inn,
            'Type' => 'Income',
            'InvoiceId' => rand(),
            'CustomerReceipt' => [
                'TaxationSystem' => $this->module->ofd_taxation_system,
                'Email' => $userData['email'],
                "InstallmentPlace" => System::fullDomain(),
                "PaymentType" => 1, //товар
            ],
            'PaymentItems' => null,
        ];

        $paramsItems = [];
        foreach ($items as $item) {
            $paramsItems[] = [
                "Label" => $item->name,
                "Price" => $item->price,
                "Quantity" => $item->count,
                "Amount" => round($item->price * $item->count),
                "Vat" => "VatNo",
                "PaymentMethod" => 4, //полный расчет
            ];
        }

        $params['CustomerReceipt']['Items'] = $paramsItems;

//        Debug::p($params); exit();

        $response = $this->send(self::ACTION_CREATE_CHECK, $params);

        $result = Json::decode($response);

        if ($result['Status'] == 'Success' && array_key_exists('Data', $result) && array_key_exists('ReceiptId', $result['Data'])) return $result['Data']['ReceiptId'];

        throw new \Exception($result['Error']['Message']);

    }

    public function send($action, $data = [], $headers = [])
    {
        $response = false;
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, self::DEMO_URL . $action . '?AuthToken=' . $this->getOfdToken());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);


            $finish_headers = [
                'Content-Type: application/json;charset=utf-8',
            ];
            if ($headers) $finish_headers = array_merge($finish_headers, $headers);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $finish_headers);


            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode([
                'Request' => $data
            ]));


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

    public function getOfdToken()
    {
        return $this->ofd_token;
    }
}