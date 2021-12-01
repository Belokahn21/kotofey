<?php

namespace app\modules\order\models\service;

use app\modules\basket\models\entity\Basket;
use app\modules\basket\models\entity\OrmBasketItem;
use app\modules\basket\models\entity\VirtualBasketItem;
use app\modules\catalog\models\entity\Product;
use app\modules\site\models\traits\ErrorTrait;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrdersItemsHelpers;

class BasketService
{
    use ErrorTrait;

    private $basket;

    public function loadBasket()
    {
        $data = \Yii::$app->request->post();
        if (!array_key_exists('OrdersItems', $data)) return false;


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

                $basket_item = new OrmBasketItem();

                $basket_item->setId($item->product_id);
                $basket_item->setPrice($item->price);
                $basket_item->setName($item->name);
                $basket_item->setCount($item->count);
                $basket_item->setPurchase($item->purchase);
                $basket_item->setDiscountPrice($item->discount_price);
                if ($item->product_id) $basket_item->setProductId($item->product_id);

                $this->basket->add($basket_item);
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
        $this->loadBasket();

        OrdersItems::deleteAll(['order_id' => $order_id]);

        foreach (Basket::findAll() as $basketItem) {

            $order_item = new OrdersItems();

            if (!$basketItem instanceof VirtualBasketItem) $order_item->product_id = $basketItem->getProductId();
            $order_item->name = $basketItem->getName();
            $order_item->price = $basketItem->getPrice();
            $order_item->count = $basketItem->getCount();
            $order_item->discount_price = $basketItem->getDiscountPrice();
            $order_item->purchase = $basketItem->getPurchase();
            $order_item->order_id = $order_id;

            if (!$order_item->validate() or !$order_item->save()) {
                $this->setErrors($order_item->getErrors());
                return false;
            }
        }

        $this->clean();

        return true;
    }
}