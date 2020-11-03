<?php

namespace app\modules\export\models\tools;


class AliexpressHelper
{
    public static function getRealWeight($weight, $gabarit = [])
    {
        if (!array_key_exists('width', $gabarit) or !array_key_exists('height', $gabarit) or !array_key_exists('length', $gabarit)) {
            return $weight;
        }

        $width = floor($gabarit['width']);
        $height = floor($gabarit['height']);
        $length = floor($gabarit['length']);

        $realWeight = floor(($width * $height * $length) / 5000);

        if ($weight > $realWeight) {
            $realWeight = $weight;
        }


        return $realWeight;
    }

    public static function getVendorName($properties)
    {
        return @array_key_exists(1, $properties) ? $properties[1] : false;
    }
}