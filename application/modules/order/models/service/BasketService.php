<?php

namespace app\modules\order\models\service;

use app\modules\basket\models\entity\Basket;
use app\modules\site\models\traits\ErrorTrait;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrdersItemsHelpers;

class BasketService
{
    use ErrorTrait;

    private $basket;

    public function load(array $data)
    {
        $this->clean();
        $this->basket = new Basket();

        $count = count($data);

        $items = [new OrdersItems()];
        for ($i = 1; $i < $count; $i++) {
            $items[] = new OrdersItems();
        }

        if (OrdersItems::loadMultiple($items, $data)) {
            foreach ($items as $item) {
                if (OrdersItemsHelpers::isEmptyItem($item)) continue;
                $this->basket->add($item);
            }
        }
    }

    public function __construct()
    {
    }

    public function clean()
    {
        Basket::clear();
    }

    public function save(int $order_id)
    {
        OrdersItems::deleteAll(['order_id' => $order_id]);

        foreach (Basket::findAll() as $item) {
            $item->order_id = $order_id;
            if (!$item->validate() or !$item->save()) {
                $this->setErrors($item->getErrors());
                return false;
            }
        }

        $this->clean();

        return true;
    }
}