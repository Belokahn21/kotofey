<?php


namespace app\modules\order\models\service;

use app\modules\acquiring\models\services\ofd\OFDFermaService;
use app\modules\bonus\models\service\BonusService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\traits\ErrorTrait;
use yii\helpers\ArrayHelper;

/**
 * @property Order $model
 * @property BasketService $basketService
 * @property StockService $stockService
 * @property NotifyService $notifyService
 * @property OrderDateService $orderDateService
 * @property OrderTrackingService $trackingService
 */
class OrderService
{
    use ErrorTrait;

    private $model;
    private $basketService;
    private $stockService;
    private $notifyService;

    public function __construct()
    {
        $this->basketService = new BasketService();
        $this->stockService = new StockService();
        $this->notifyService = new NotifyService();
        $this->orderDateService = new OrderDateService();
        $this->trackingService = new OrderTrackingService();
    }

    public function createOrder()
    {
        if (!\Yii::$app->request->isPost) return false;

        try {
            $helper = new OrderHelper();
            $model = $helper->create($this->model);
        } catch (\Exception $e) {
            $this->setErrors($helper->getErrors());
            throw new \Exception($e->getMessage());
        }

        $order_id = $model->id;

        if (!$this->basketService->save($order_id)) {
            $this->setErrors($this->basketService->getErrors());
            throw new \Exception('Ошибка при сохранении товаров к заказу');
        }

        $this->orderDateService->setOrderModel($model);
        $this->orderDateService->create();

        $this->trackingService->addOrderModel($model);
        $this->trackingService->create();

        //refresh model class
        $model = Order::findOne($order_id);
        $this->notifyService->sendClientNotify($model); //todo: из-за того что в заказе нет товаров приходится выгружать из бд заного с заполнеными данными
        $this->notifyService->sendMessageToVkontakte($order_id, ArrayHelper::getValue(\Yii::$app->params, 'vk.access_token'));
        //ecommerce operations
        BonusService::getInstance()->addUserBonus($model);
        OFDFermaService::getInstance()->doSendCheck($model, [
            'email' => $model->email,
            'phone' => $model->phone,
        ]);
        $this->stockService->setOrderModel($model);
        $this->stockService->plus();
        $this->stockService->minus();

        return $model;
    }

    public function deleteOrder()
    {
    }

    public function updateOrder()
    {
        if (!\Yii::$app->request->isPost) return false;

        try {
            $helper = new OrderHelper();
            $model = $helper->update($this->model);
        } catch (\Exception $e) {
            $this->setErrors($helper->getErrors());
            throw new \Exception($e->getMessage());
        }

        $order_id = $model->id;


        $this->basketService->load(\Yii::$app->request->post());
        if (!$this->basketService->save($order_id)) {
            $this->setErrors($this->basketService->getErrors());
            throw new \Exception('Ошибка при сохранении товаров к заказу');
        }

        $this->orderDateService->setOrderModel($model);
        $this->orderDateService->update();

        $this->trackingService->addOrderModel($model);
        $this->trackingService->update();

        $model = Order::findOne($order_id); //refresh model class

        $this->stockService->setOrderModel($model);
        $this->stockService->plus();
        $this->stockService->minus();

        return $model;
    }


    public function setModel(Order $model)
    {
        $this->model = $model;
    }
}