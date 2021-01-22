<?php


namespace app\models\tool\seo;


class ProductTitle extends Title
{
    public static function show($text)
    {
        return "Купить " . $text . " - Интернет-зоомагазин | Барнаул";
    }
}