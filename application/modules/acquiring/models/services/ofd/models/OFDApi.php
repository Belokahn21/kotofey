<?php

namespace app\modules\acquiring\models\services\ofd\models;

use app\modules\acquiring\models\services\ofd\models\helper\OFDApiHelper;
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
    const ACTION_STATUS_CHECK = 'status';

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
            'InvoiceId' => $order->id,
            'CustomerReceipt' => [
                'TaxationSystem' => $this->module->ofd_taxation_system,
                'Email' => $userData['email'],
                "InstallmentPlace" => System::fullDomain(),
                "PaymentType" => 1, //товар
                'PaymentItems' => [
                    [
                        'PaymentType' => OFDApiHelper::getPaymentType($order),
                        'Sum' => OrderHelper::orderSummary($order),
                    ]
                ],
            ],
            "Cashier" => [
                "Name" => "Васин Константин Викторович",
//                "Inn" => "222261129226"
            ]
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

    public function statusCheckByCheckId(string $check_id)
    {
        $response = $this->send(self::ACTION_STATUS_CHECK, [
            'ReceiptId' => $check_id
        ]);

        $result = Json::decode($response);

//        Debug::p($result);
        return $result;
    }

    public function statusCheckByOrderId(int $order_id)
    {
        $response = $this->send(self::ACTION_STATUS_CHECK, [
            'InvoiceId' => $order_id
        ]);

        $result = Json::decode($response);

//        Debug::p($result);
        return $result;
    }

    public function send($action, $data = [], $headers = [])
    {
        $response = false;
        $requestUrl = YII_ENV == 'dev' ? self::DEMO_URL : self::URL;

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $requestUrl . $action . '?AuthToken=' . $this->getOfdToken());
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