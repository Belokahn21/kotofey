<?php

namespace app\modules\order\models\behaviors;

use app\modules\order\models\entity\Order;
use app\modules\order\models\service\NotifyService;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class NotifyBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterCreateOrder',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateOrder',
        ];
    }

    public function afterCreateOrder()
    {
        $model = $this->owner;

        $ns = new NotifyService();
        $ns->sendClientNotify(Order::findOne($model->id));
    }

    public function afterUpdateOrder()
    {
        $model = $this->owner;

        $ns = new NotifyService();
        $ns->sendClientNotify(Order::findOne($model->id));
    }
}