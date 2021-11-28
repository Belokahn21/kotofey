<?php


namespace app\modules\order\models\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\order\models\traits\ErrorTrait;
use app\modules\order\models\entity\OrdersItems;

class OrdersItemsHelpers
{
    use ErrorTrait;

    public function save(int $order_id): bool
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
                    $this->setErrors($item->getErrors());
                    return false;
                }
            }
        }

        return true;
    }

    public function addErrors(string $text)
    {
        $this->errors[] = $text;
    }

    public function getErrors()
    {
        return $this->errors;
    }


    public static function isEmptyItem(OrdersItems $item): bool
    {
        return empty($item->name) && empty($item->price) && empty($item->count);
    }
}