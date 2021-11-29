<?php

namespace app\modules\order\models\service;

use Yii;
use app\modules\order\models\entity\Order;
use app\modules\site\models\traits\ErrorTrait;
use app\modules\order\models\entity\OrderTracking;

/**
 * @property Order $orderModel
 */
class OrderTrackingService
{
    use ErrorTrait;

    private $orderModel;

    public function addOrderModel(Order $model)
    {
        $this->orderModel = $model;
    }

    public function create(): bool
    {
        $trackForm = new OrderTracking();
        $data = Yii::$app->request->post();

        if (!$trackForm->load($data)) return false;

        $trackForm->order_id = $this->orderModel->id;

        if (!$trackForm->validate() || !$trackForm->save()) {
            $this->setErrors($trackForm->getErrors());
            return false;
        }

        return true;
    }

    public function update(): bool
    {
        if (!$trackForm = OrderTracking::findByOrderId($this->orderModel->id)) return $this->create();

        $data = Yii::$app->request->post();

        if ($trackForm->load($data)) return false;

        $trackForm->order_id = $this->orderModel->id;

        if (!$trackForm->validate() || $trackForm->update() === false) {
            $this->setErrors($trackForm->getErrors());
            return false;
        }

        return true;
    }

    public function delete()
    {
    }
}