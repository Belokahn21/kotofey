<?php

namespace app\models\tool\seo;

class Title
{
    public static function showTitle($text)
    {
        $format = "%s - Интернет зоомагазин Котофей";
        return sprintf($format, $text);
    }
}
