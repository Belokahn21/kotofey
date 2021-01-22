<?php

namespace app\models\tool\seo;

class Title implements TitleInterface
{
    public static function show($text)
    {
        $format = "%s - интернет зоомагазин Котофей";
        return sprintf($format, $text);
    }
}
