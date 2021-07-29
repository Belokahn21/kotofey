<?php

namespace app\modules\delivery\models\helper;

class DimensionHelper
{
    public static function getBoxSquare(int $width, int $height, int $length)
    {
        return (($length + $width) * 2 + 59) * ($width + $height + 8) / 10000;
    }

    public static function getCardboardSummary($s, $p = 0.58)
    {
        return $s * $p;
    }

    /* Принимает и возращает значение в сантиметрах */
    public static function getBoxVolume(int $width, int $height, int $length)
    {
        return $width * $height * $length;
    }
}