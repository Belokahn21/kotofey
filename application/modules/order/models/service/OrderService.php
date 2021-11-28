<?php


namespace app\modules\order\models\service;

use app\modules\acquiring\models\services\ofd\OFDFermaService;
use app\modules\bonus\models\service\BonusService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\helpers\DateDeliveryHelper;
use app\modules\order\models\traits\ErrorTrait;
use yii\helpers\ArrayHelper;

class OrderService
{
    use ErrorTrait;

    public function createOrder(string $scenario = Order::SCENARIO_DEFAULT): Order
    {
        try {
            $helper = new OrderHelper();
            $model = $helper->createOrder($scenario);
        } catch (\Exception $e) {
            $this->setErrors($helper->getErrors());
            throw new \Exception($e->getMessage());
        }

        $order_id = $model->id;


        $basket_service = new BasketService(\Yii::$app->request->post());
        if (!$basket_service->save($order_id)) {
            $this->setErrors($basket_service->getErrors());
            throw new \Exception('Ошибка при сохранении товаров к заказу');
        }

        $basket_service->clean();

        (new DateDeliveryHelper())->save($order_id);


        //refresh model class
        $model = Order::findOne($order_id);

        $notifyService = new NotifyService();
        $notifyService->sendClientNotify($model); //todo: из-за того что в заказе нет товаров приходится выгружать из бд заного с заполнеными данными
        $notifyService->sendMessageToVkontakte($order_id, ArrayHelper::getValue(\Yii::$app->params, 'vk.access_token'));


        //ecommerce operations
        BonusService::getInstance()->addUserBonus($model);
        OFDFermaService::getInstance()->doSendCheck($model, [
            'email' => $model->email,
            'phone' => $model->phone,
        ]);


        $ss = new StockService($model);
        $ss->plus();
        $ss->minus();

        return $model;
    }

    public function deleteOrder()
    {
    }

    public function updateOrder()
    {
    }
}