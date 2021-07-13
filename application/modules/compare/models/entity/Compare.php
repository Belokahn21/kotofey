<?php

namespace app\modules\compare\models\entity;


use app\modules\catalog\models\entity\Offers;

class Compare
{
    const COMPARE_SESSION_KEY = 'compare';

    public $product_id;

    public function save()
    {
        \Yii::$app->session->open();
        $_SESSION[self::COMPARE_SESSION_KEY][$this->product_id] = $this->product_id;

        if (array_key_exists(self::COMPARE_SESSION_KEY, $_SESSION)) {
            if (array_key_exists($this->product_id, $_SESSION[self::COMPARE_SESSION_KEY])) {
                return true;
            }
        }

        return false;
    }

    public static function getListId()
    {
        \Yii::$app->session->open();
        if ($compare = \Yii::$app->session->get(self::COMPARE_SESSION_KEY)) {
            return $compare;
        }

        return [];
    }

    public static function findAll()
    {
        $items = array();
        \Yii::$app->session->open();
        if ($compare = \Yii::$app->session->get(self::COMPARE_SESSION_KEY)) {
            foreach ($compare as $product_id => $item) {
                $items[] = Offers::findOne($product_id);
            }
        }
        return $items;
    }

    public static function clean()
    {
        \Yii::$app->session->open();
        \Yii::$app->session->remove(self::COMPARE_SESSION_KEY);
    }
}