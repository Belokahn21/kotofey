<?php


namespace app\modules\order\models\helpers;

use Yii;
use app\modules\order\models\entity\OrdersItems;

class OrdersItemsHelpers
{
    /**
     * @param int $order_id
     * @return OrdersItems|bool
     */
    public function loadItemsAndSave(int $order_id)
    {
        $count = count(Yii::$app->request->post('OrdersItems', []));

        $items = [new OrdersItems()];
        for ($i = 1; $i < $count; $i++) {
            $items[] = new OrdersItems();
        }

        if (OrdersItems::loadMultiple($items, Yii::$app->request->post())) {
            foreach ($items as $item) {

                if (OrderHelper::isEmptyItem($item)) continue;

                $item->order_id = $order_id;
                if (!$item->validate() || !$item->save()) {
                    return $item;
                }
            }


            return true;
        }

        return false;
    }
}