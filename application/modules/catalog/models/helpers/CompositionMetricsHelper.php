<?php


namespace app\modules\catalog\models\helpers;


class CompositionMetricsHelper
{
    const WEIGHT_PERCENT = 'percent';
    const WEIGHT_GG = 'g';
    const WEIGHT_MG = 'mg';
    const WEIGHT_KG = 'kg';

    public static function getMetrics()
    {
        return [
            self::WEIGHT_PERCENT => '%',
            self::WEIGHT_GG => 'Грамм',
            self::WEIGHT_MG => 'Милиграмм',
            self::WEIGHT_KG => 'Килограмм',
        ];
    }
}