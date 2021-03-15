<?php


namespace app\modules\payment\models\services\equiring;


use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\payment\models\services\equiring\banks\EquiringBank;
use app\modules\site\models\tools\Curl;
use yii\helpers\Json;

class EquiringTerminal
{
    private $bank;
    private $paramRequest;

    const REGISTER_ORDER = 'https://3dsec.sberbank.ru/payment/rest/register.do';

    public function __construct(EquiringBank $paymentBank)
    {
        $this->bank = $paymentBank;
    }

    public function registerOrder(Order $order)
    {
        $this->bank->getAuthParams($this->paramRequest);

        $curl = new Curl();
        $this->extendParams($this->paramRequest, [
            'orderNumber' => rand(),
            'currency' => 643,
//            'orderNumber' => $order->id,
            'amount' => OrderHelper::orderSummary($order) * 100,
            'returnUrl' => 'https://kotofey.store/payment/return/',
        ]);

        return Json::decode($curl->post(self::REGISTER_ORDER, $this->paramRequest));
    }

    private function extendParams(&$old, $new)
    {
        $old = array_merge($old, $new);
    }
}