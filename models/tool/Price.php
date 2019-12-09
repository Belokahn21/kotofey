<?php

namespace app\models\tool;


class Price
{
    public static function format($price)
    {
        return number_format($price, 0, '.', ' ');
    }
}