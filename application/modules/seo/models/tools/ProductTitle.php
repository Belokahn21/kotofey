<?php


namespace app\modules\seo\models\tools;


class ProductTitle extends Title
{
    public static function show($text)
    {
        return "Купить " . $text . " - Интернет-зоомагазин | Барнаул";
    }
}