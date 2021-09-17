<?php

namespace app\modules\order\widgets\GroupBuy;


use app\modules\order\models\entity\Customer;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use yii\base\Widget;

class GroupBuyWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $groupedData = array();
        $orders = Order::find()->all();

        foreach ($orders as $order) {
            if (!empty($order->phone)) {
                $groupedData[$order->phone] = null;
            }
        }

        $this->loadOrderItems($groupedData);
        $this->loadCards($groupedData);
        $this->groupItems($groupedData);

        return $this->render($this->view, [
            'groupedData' => $groupedData
        ]);
    }

    public function loadCards(array &$data)
    {
        foreach ($data as $phone => $someData) {

            $card = Customer::findOne(['phone' => $phone]);

            if ($card) $data[$phone]['card'] = $card;
        }
    }

    public function loadOrderItems(array &$data)
    {
        foreach ($data as $phone => $someData) {
            $orders = Order::find()->where(['phone' => $phone])->all();
            if ($orders) {
                foreach ($orders as $order) {

                    if ($order->items) {
                        foreach ($order->items as $item) {
                            $data[$phone]['items'][] = $item;
                        }
                    }

                }
            }
        }
    }

    public function groupItems(array &$data)
    {
        foreach ($data as $phone => &$userData) {
            if (array_key_exists('items', $userData)) {
                foreach ($userData['items'] as $item) {
//                    if ($item->product) {
                    $userData['group_items']['item'][$item->product_id] = $item;
                    $userData['group_items']['count'][$item->product_id][] = $item;
//                    }
                }
            }
        }

    }

    public function sortGroupItems(array &$data)
    {
        foreach ($data as $phone => &$userData) {
            if (array_key_exists('group_items', $userData)) {
                usort($userData['group_items'], function ($a, $b) {
                    return count($b) - count($a);
                });
            }
        }
    }
}