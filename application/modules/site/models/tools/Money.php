<?php

namespace app\modules\site\models\tools;

class Money
{
    public static function convertCopToRub(int $amount)
    {
        return $amount / 100;
    }
}