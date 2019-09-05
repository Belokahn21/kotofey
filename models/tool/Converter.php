<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 22:24
 */

namespace app\models\tool;


class Converter
{
    public static function mbyteToKbyte($size)
    {
        return round(($size / 1024) / 1024, 2);
    }
}