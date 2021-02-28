<?php

namespace app\modules\order\models\helpers;


class OrderDateHelper
{
    public static function getAvailableTimes()
    {
        $times = [];

        for ($i = 1; $i < 20; $i++) {
            $times[] = $i . '.02.2020';
        }

        return $times;
    }

    public static function getAvailableDates($basketItems)
    {
        $dates = [];
        $countDays = 0;

        $currentDate = new \DateTime();

        while ($countDays < 15) {

            $countDays++;
            if ($countDays < 5) continue;

            $dates[] = $currentDate->add(new \DateInterval('P1D'))->format('d.m.Y');

        }

        return $dates;
    }
}