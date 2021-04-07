<?php

namespace app\modules\site\models\tools;


class Price
{
    public static function format($price)
    {
        return number_format($price, 0, '.', ' ');
    }

    public static function toFloat(int $summ)
    {
        return $summ;
//        return floor((float) floatval($summ));
    }
}