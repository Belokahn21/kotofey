<?php

namespace app\modules\order\models\service;


use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;

class StockService
{
    private $_model;

    public function setOrderModel(Order $model)
    {
        $this->_model = $model;
    }

    public function plus()
    {
        if ($this->_model->status == 8) {
            OrderHelper::plusStockCount($this->_model);
        }
    }

    public function minus()
    {
        if ($this->_model->is_paid && $this->_model->is_close) {
            OrderHelper::minusStockCount($this->_model);
        }
    }
}