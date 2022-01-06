<?php

namespace app\modules\basket\models\entity;


use app\modules\basket\models\entity\interfaces\BasketItemInterface;
use app\modules\site\models\tools\Debug;
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

    public function add(BasketItemInterface $item)
    {
        $_SESSION[self::BASKET_KEY][$item->getId()] = $item;
    }

    public function delete($product_id)
    {
        unset($_SESSION[self::BASKET_KEY][$product_id]);
        return true;
    }

    /**
     * @param $product_id
     * @return BasketItemInterface
     */
    public static function findOne(int $product_id)
    {
        $basket = \Yii::$app->session->get(self::BASKET_KEY);
        if ($basket !== null) {
            if (array_key_exists($product_id, $basket)) {
                return $basket[$product_id];
            }
        }

        return new OrmBasketItem();
    }

    public function update(BasketItemInterface $item, int $count)
    {
        /* @var $item BasketItemInterface */
        if ($item = $_SESSION[self::BASKET_KEY][$item->getId()]) {
            $item->setCount($count);
        }

        $_SESSION[self::BASKET_KEY][$item->getId()] = $item;
    }

    public function exist(int $product_id)
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

    /**
     * @return BasketItemInterface[]
     * */
    public static function findAll()
    {
        $items = [];
        if ($basket = \Yii::$app->session->get(self::BASKET_KEY)) {
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


    public function cash(bool $withDiscount = false)
    {
        $cash = 0;

        if (!empty($_SESSION[self::BASKET_KEY])) {
            /* @var $item BasketItemInterface */
            foreach ($_SESSION[self::BASKET_KEY] as $id => $item) {
                if ($withDiscount) {
                    $cash += ($item->discount_price ? $item->discount_price : $item->getPrice()) * $item->getCount();
                } else {
                    $cash += $item->getCount() * $item->getCount();
                }
            }
        }

        return $cash;
    }
}