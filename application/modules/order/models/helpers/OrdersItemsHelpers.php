<?php


namespace app\modules\order\models\helpers;

use app\modules\site\models\tools\Debug;
use Yii;
use app\modules\order\models\entity\OrdersItems;
use yii\helpers\ArrayHelper;

class OrdersItemsHelpers
{
    /**
     * @param int $order_id
     * @return OrdersItems|bool
     */
    public function saveItems(int $order_id)
    {
        $data = Yii::$app->request->post();
        $count = count(ArrayHelper::getValue($data, 'OrdersItems', []));

        $items = [new OrdersItems()];
        for ($i = 1; $i < $count; $i++) {
            $items[] = new OrdersItems();
        }

        if (OrdersItems::loadMultiple($items, $data)) {
            foreach ($items as $item) {

                if ($this->isEmptyItem($item)) continue;

                $item->order_id = $order_id;
                if (!$item->validate() || !$item->save()) {
                    return $item;
                }
            }


            return true;
        }

        return false;
    }


    public static function isEmptyItem(OrdersItems $item)
    {
        return empty($item->name) && empty($item->price) && empty($item->count);
    }
}