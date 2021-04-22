<?php


namespace app\modules\payment\models\services\equiring;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\payment\models\services\equiring\banks\EquiringBank;
use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\System;
use yii\helpers\Json;
use yii\helpers\Url;

class EquiringTerminalService
{
    private $bank;
    private $paramRequest = array();

    const REGISTER_ORDER = 'https://3dsec.sberbank.ru/payment/rest/register.do';
    const ROLLBACK_MONEY = 'https://3dsec.sberbank.ru/payment/rest/refund.do';
    const CANCEL_PAY = 'https://3dsec.sberbank.ru/payment/rest/reverse.do';
    const DECLINE = 'https://3dsec.sberbank.ru/payment/rest/decline.do';

    public function __construct(EquiringBank $paymentBank)
    {
        $this->bank = $paymentBank;
    }

    public function createOrder(Order $order)
    {
        $this->bank->getAuthParams($this->paramRequest);

        $curl = new Curl();
        $this->extendParams($this->paramRequest, [
            'orderNumber' => $order->id,
            'currency' => 643,
            'email' => $order->email,
            'phone' => $order->phone,
            'amount' => OrderHelper::orderSummary($order) * 100,
            'returnUrl' => System::fullDomain() . Url::to('/payment/success/'),
            'failUrl' => System::fullDomain() . Url::to('/payment/fail/'),
        ]);

        return Json::decode($curl->post(self::REGISTER_ORDER, $this->paramRequest));
    }

    public function cancelPay(AcquiringOrder $order)
    {
        $this->bank->getAuthParams($this->paramRequest);

        $curl = new Curl();
        $this->extendParams($this->paramRequest, [
            'orderId' => $order->identifier_id,
        ]);

        return Json::decode($curl->post(self::CANCEL_PAY, $this->paramRequest));
    }

    public function decline(AcquiringOrder $order)
    {
        $this->bank->getAuthParams($this->paramRequest);

        $curl = new Curl();
        $this->extendParams($this->paramRequest, [
            'orderId' => $order->identifier_id,
            'merchantLogin' => "T2222889641",
        ]);

        return Json::decode($curl->post(self::DECLINE, $this->paramRequest));
    }

    public function rollbackMoney(AcquiringOrder $order, $amount)
    {
        $this->bank->getAuthParams($this->paramRequest);

        $curl = new Curl();
        $this->extendParams($this->paramRequest, [
            'orderId' => $order->identifier_id,
            'amount' => $amount,
        ]);

        return Json::decode($curl->post(self::ROLLBACK_MONEY, $this->paramRequest));
    }

    public function saveHistoryPaymentTransaction(Order $order, $identificator)
    {
        $model = new AcquiringOrder();
        $model->order_id = $order->id;
        $model->identifier_id = $identificator;

        if (!$model->validate() || !$model->save()) {
            return [
                'status' => 500,
                'errors' => $model->getErrors()
            ];
        }

        return [
            'status' => 200,
            'message' => 'Данные о транзакции успешно сохранены'
        ];
    }

    private function extendParams(&$old, $new)
    {
        $old = array_merge($old, $new);
    }
}