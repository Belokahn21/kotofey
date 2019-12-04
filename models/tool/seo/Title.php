<?php

namespace app\models\tool\seo;

class Title
{
    public static function showTitle($text)
    {
        $format = "Зоомагазин Котофей - %s";
        return sprintf($format, $text);
    }
}
