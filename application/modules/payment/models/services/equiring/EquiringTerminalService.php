<?php


namespace app\modules\payment\models\services\equiring;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\payment\models\services\equiring\banks\EquiringBank;
use app\modules\site\models\tools\Curl;
use yii\helpers\Json;
use yii\helpers\Url;

class EquiringTerminalService
{
    private $bank;
    private $paramRequest = array();

    const REGISTER_ORDER = 'https://3dsec.sberbank.ru/payment/rest/register.do';

    public function __construct(EquiringBank $paymentBank)
    {
        $this->bank = $paymentBank;
    }

    public function registerOrder(Order $order)
    {
        $result = $this->createOrder($order);

        if (is_array($result) && array_key_exists('orderId', $result) && array_key_exists('formUrl', $result)) return false;

        if (!$this->signalOrder($order, $result['orderId'])) return false;

        return $result;
    }

    public function createOrder(Order $order)
    {
        $this->bank->getAuthParams($this->paramRequest);

        $curl = new Curl();
        $this->extendParams($this->paramRequest, [
            'orderNumber' => $order->id . '-test-2021',
            'currency' => 643,
            'amount' => OrderHelper::orderSummary($order) * 100,
            'returnUrl' => Url::to('/payment/result/'),
        ]);

        return Json::decode($curl->post(self::REGISTER_ORDER, $this->paramRequest));
    }

    public function signalOrder(Order $order, $identificator)
    {
        $model = new AcquiringOrder();
        $model->order_id = $order->id;
        $model->identifier_id = $identificator;
        return $model->validate() && $model->save();
    }

    private function extendParams(&$old, $new)
    {
        $old = array_merge($old, $new);
    }
}