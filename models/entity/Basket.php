<?php

namespace app\models\entity;


use app\models\tool\Debug;

/**
 * Basket model
 *
 * @property Product $product
 * @property integer $count
 * @property Promo $promo
 */
class Basket
{
    public static function getInstance()
    {
        return new Basket();
    }

    public function __construct()
    {
        \Yii::$app->session->open();
    }

    public function add(BasketItem $item)
    {
        $_SESSION['basket'][$item->getProductId()] = $item;
    }

    public function delete($product_id)
    {
//        \Yii::$app->session->open();
        unset($_SESSION['basket'][$product_id]);
//        if ($this->exist($product_id)) {
//            return false;
//        }
        return true;
    }

    /**
     * @param $product_id
     * @return BasketItem
     */
    public static function findOne($product_id)
    {
        $basket = \Yii::$app->session->get('basket');
        return $basket[$product_id] ? $basket[$product_id] : new BasketItem();
    }

    public function update(BasketItem $item, $count)
    {
//        \Yii::$app->session->open();

        /* @var $item BasketItem */
        if ($item = $_SESSION['basket'][$item->getProductId()]) {
            $item->setCount($count);
        }

        $_SESSION['basket'][$item->getProductId()] = $item;
    }

    public function exist($product_id)
    {
        \Yii::$app->session->open();
        $basket = \Yii::$app->session->get('basket');
        if ($basket[$product_id]) {
            return true;
        }
        return false;
    }

    public static function findAll()
    {
        $items = false;
        if ($basket = \Yii::$app->session->get('basket')) {
            $items = array();
            foreach ($basket as $product_id => $item) {
                $items[$product_id] = $item;
            }
        }

        return $items;
    }

    public static function clear()
    {
        unset($_SESSION['basket']);
    }

    public static function count()
    {
        if (\Yii::$app->session->get('basket')) {
            return count(\Yii::$app->session->get('basket'));
        }
        return false;
    }

    public function isEmpty()
    {
//        if (!\Yii::$app->session->get('basket') or $this->count() == 0) {
//            return true;
//        } else {
//            return false;
//        }
    }


    public function cash()
    {
        $cash = 0;

        /* @var $promo Promo */
        if (!empty($_SESSION['basket'])) {
            /* @var $item BasketItem */
            foreach ($_SESSION['basket'] as $id => $item) {
                    $cash += $item->getProduct()->price * $item->getCount();
            }
        }

        return $cash;
    }
}