<?php

namespace app\modules\basket\models\entity;


use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\OrdersItems;
use yii\base\Model;

/**
 * Basket model
 *
 * @property Product $product
 * @property integer $count
 */
class Basket extends Model
{
    const EVENT_AFTER_ADD_ITEM = 'item_add';
    const BASKET_KEY = 'basket';

    public static function getInstance()
    {
        return new Basket();
    }

    public function __construct($config = [])
    {
        parent::__construct($config);

        \Yii::$app->session->open();
    }

    public function add(OrdersItems $item)
    {
        $_SESSION[self::BASKET_KEY][$item->product_id] = $item;
    }

    public function delete($product_id)
    {
        unset($_SESSION[self::BASKET_KEY][$product_id]);
        return true;
    }

    /**
     * @param $product_id
     * @return OrdersItems
     */
    public static function findOne($product_id)
    {
        $basket = \Yii::$app->session->get(self::BASKET_KEY);
        if ($basket !== null) {
            if (array_key_exists($product_id, $basket)) {
                return $basket[$product_id];
            }
        }

        return new OrdersItems();
    }

    public function update(OrdersItems $item, $count)
    {
        /* @var $item OrdersItems */
        if ($item = $_SESSION[self::BASKET_KEY][$item->product_id]) {
            $item->count = $count;
        }

        $_SESSION[self::BASKET_KEY][$item->product_id] = $item;
    }

    public function exist($product_id)
    {
        \Yii::$app->session->open();
        $basket = \Yii::$app->session->get(self::BASKET_KEY);
        if ($basket !== null) {
            if (array_key_exists($product_id, $basket)) {
                return true;
            }
        }
        return false;
    }

    public static function findAll()
    {
        $items = false;
        if ($basket = \Yii::$app->session->get(self::BASKET_KEY)) {
            $items = array();
            foreach ($basket as $product_id => $item) {
                $items[$product_id] = $item;
            }
        }

        return $items;
    }

    public static function clear()
    {
        unset($_SESSION[self::BASKET_KEY]);
    }

    public static function count()
    {
        if (\Yii::$app->session->get(self::BASKET_KEY)) {
            return count(\Yii::$app->session->get(self::BASKET_KEY));
        }
        return false;
    }

    public function isEmpty()
    {
        $basket = \Yii::$app->session->get(self::BASKET_KEY);
        if ($basket) {
            if (count($basket) > 0) {
                return false;
            }
        }

        return true;
    }


    public function cash()
    {
        $cash = 0;

        /* @var $promo Promo */
        if (!empty($_SESSION[self::BASKET_KEY])) {
            /* @var $item OrdersItems */
            foreach ($_SESSION[self::BASKET_KEY] as $id => $item) {
                $cash += $item->price * $item->count;
            }
        }

        return $cash;
    }
}