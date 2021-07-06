<?php


namespace app\modules\catalog\models\helpers;


class CompositionMetricsHelper
{
    const WORLD_UNIT = 'world_unit';
    const WEIGHT_PERCENT = 'percent';

    const WEIGHT_GG = 'gr';
    const WEIGHT_MG = 'mg';
    const WEIGHT_KG = 'kg';

    const LIQUID_GG = 'g';
    const LIQUID_MG = 'mlg';
    const LIQUID_L = 'l';

    public static function getMetrics()
    {
        return [
            self::WORLD_UNIT => 'МЕ',

            self::WEIGHT_PERCENT => '%',

            self::WEIGHT_GG => 'Грамм(гр)',
            self::WEIGHT_MG => 'Милиграмм(мг)',
            self::WEIGHT_KG => 'Килограмм(кг)',

            self::LIQUID_GG => 'Грамм(г)',
            self::LIQUID_MG => 'Милиграмм(мл)',
            self::LIQUID_L => 'Литр(л)',
        ];
    }
}