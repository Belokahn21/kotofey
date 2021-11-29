<?php

namespace app\modules\order\models\service;

use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderDate;
use app\modules\site\models\traits\ErrorTrait;

class OrderDateService
{
    use ErrorTrait;

    private $model;

    public function __construct()
    {
    }

    public function create(Order $order)
    {
        $data = \Yii::$app->request->post();

        $this->model = new OrderDate();

        if (!$this->model->load($data)) return false;

        $this->model->order_id = $order;

        if (!$this->model->validate() || !$this->model->save()) return false;

        return true;
    }

    public function update(Order $order)
    {
        $data = \Yii::$app->request->post();

        if (!$this->model = OrderDate::findOneByOrderId($order->id)) $this->model = new OrderDate();

        if (!$this->model->load($data)) return false;

        $this->model->order_id = $order;

        if (!$this->model->validate() || !$this->model->update() === false) return false;

        return true;
    }

    public function delete()
    {
    }
}