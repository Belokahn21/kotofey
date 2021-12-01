<?php

namespace app\modules\logistic\models\forms;


use app\modules\order\models\entity\Order;
use app\modules\order\models\service\OrderService;
use yii\base\Model;

class LogisticForm extends Model
{
    public $order_id;

    public function rules()
    {
        return [
            ['order_id', 'required'],
            ['order_id', 'integer'],
        ];
    }

    public function start()
    {
        $orderService = new OrderService();
        $orderService->setModel(Order::findOne($this->order_id));
        return $orderService->completeOrder();
    }
}