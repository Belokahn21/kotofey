<?php


namespace app\modules\payment\models\services\equiring\banks;


use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\payment\models\services\equiring\SberbankAuth;
use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class Sberbank
{
    const REGISTER_ORDER = 'https://3dsec.sberbank.ru/payment/rest/register.do';

    private $options;
    private $paramRequest;

    public function __construct(SberbankAuth $auth)
    {
        $auth->getAuthParams($this->paramRequest);
    }

    public function getPaymentLink(Order $order)
    {
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