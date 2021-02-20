<?php

namespace app\modules\order\models\helpers;


class OrderDateHelper
{
    public static function getAvailableDates()
    {
        $dates = [];

        for ($i = 1; $i < 20; $i++) {
            $dates[] = $i . '.02.2020';
        }

        return $dates;
    }
}