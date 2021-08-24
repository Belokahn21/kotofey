<?php


namespace app\modules\payment\controllers;


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\models\entity\Order;
use app\modules\site\models\tools\Debug;
use app\widgets\notification\Alert;
use yii\web\Controller;
use function GuzzleHttp\Psr7\str;

class PaymentController extends Controller
{
    public function actionSuccess()
    {

        if (!$acOrder = AcquiringOrder::findOneByBankId(\Yii::$app->request->get('orderId'))) return $this->redirect(['/']);

        if (!$order = Order::findOne($acOrder->order_id)) return $this->redirect(['/']);

        $order->is_paid = true;
        $order->phone = (string)$order->phone;

        if ($order->validate() && $order->update()) {
            Alert::setSuccessNotify('Заказ успешно оформлен и оплачен. В ближайшее время с вами свяжутся операторы для уточнения заказа.');
        }

        return $this->redirect(['/']);
    }

    public function actionFail()
    {
        return $this->render('result');
    }
}