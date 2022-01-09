<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 22:24
 */

namespace app\modules\site\models\tools;


class Converter
{
    /* byte in kbyte*/
    public static function mbyteToKbyte($size)
    {
        return round(($size / 1024), 2);
    }

    /* kopeiki to rubli */
    public static function pennyToRub($amount, bool $isNeedRound = false)
    {
        if ($isNeedRound) {
            return round($amount / 100);
        } else {
            return $amount / 100;
        }
    }
}