<?php

namespace app\modules\delivery\models\helper;


class RuPostHelper
{
    public static function getMass($amount)
    {
        $amount = floatval($amount);
        return round($amount * 1000);
    }
}