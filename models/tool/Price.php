<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:11
 */

namespace app\models\tool;


class Price
{
    public static function format($price)
    {
        return number_format($price, 0, '.', ' ');
    }
}