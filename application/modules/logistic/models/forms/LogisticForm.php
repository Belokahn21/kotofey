<?php

namespace app\modules\logistic\models\forms;


use app\modules\order\models\entity\Order;
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
        if (!$order = Order::findOne($this->order_id)) return false;

        $order->is_close = true;
        $order->is_paid = true;
        $order->status = 3;
        $order->phone = (string)$order->phone;

        return $order->validate() && $order->update();
    }
}