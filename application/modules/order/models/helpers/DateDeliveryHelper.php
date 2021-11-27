<?php

namespace app\modules\order\models\helpers;

use app\modules\order\models\entity\OrderDate;

class DateDeliveryHelper
{
    public function create(int $order_id)
    {
        $model = new OrderDate();
        $data = \Yii::$app->request->post();


        if ($model->load($data)) {
            $model->order_id = $order_id;
            if (!$model->validate() || !$model->save()) {
                return false;
            }
        }

        return true;
    }
}