<?php

namespace app\modules\site\models\tools;

class Price
{
    public static function format($price)
    {
        return number_format($price, 0, '.', ' ');
    }

    public static function normalize($str)
    {
        $str = str_replace(' ', '', $str);
        $str = str_replace(',', '.', $str);
        $str = (float)$str;
        $str = round($str);

        return $str;
    }
}