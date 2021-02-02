<?php

namespace app\modules\seo\models\tools;

class Title implements TitleInterface
{
    public static function show($text)
    {
        $format = "%s - интернет зоомагазин Котофей";
        return sprintf($format, $text);
    }
}
