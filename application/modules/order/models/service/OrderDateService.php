<?php

namespace app\modules\order\models\service;

use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderDate;
use app\modules\site\models\traits\ErrorTrait;

/**
 * @property Order $orderModel
 * @property OrderDate $model
 */
class OrderDateService
{
    use ErrorTrait;

    private $model;
    private $orderModel;

    public function setOrderModel(Order $model)
    {
        $this->orderModel = $model;
    }

    public function create()
    {
        $data = \Yii::$app->request->post();

        $this->model = new OrderDate();

        if (!$this->model->load($data)) return false;

        $this->model->order_id = $this->orderModel->id;

        if (!$this->model->validate() || !$this->model->save()) return false;

        return true;
    }

    public function update()
    {
        $data = \Yii::$app->request->post();

        if (!$this->model = OrderDate::findOneByOrderId($this->orderModel->id)) return $this->create();

        if (!$this->model->load($data)) return false;

        $this->model->order_id = $this->orderModel->id;

        if (!$this->model->validate() || !$this->model->update() === false) return false;

        return true;
    }

    public function delete()
    {
    }
}