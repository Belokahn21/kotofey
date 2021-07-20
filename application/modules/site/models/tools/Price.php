<?php

namespace app\modules\site\models\tools;

class Price
{
    public static function showFormat($price)
    {
        $cur_icon = Currency::getInstance()->show();
        return static::format($price) . ' ' . $cur_icon;
    }

    public static function format($price)
    {
        return number_format($price, 0, '.', ' ');
    }

    public static function normalize($price)
    {
        $price = str_replace(' ', '', $price);
        $price = str_replace(',', '.', $price);
        $price = (float)$price;
        $price = round($price);

        return intval($price);
    }
}