<?php


namespace app\models\tool\import;


abstract class Importer implements Import
{
    public $newItems = array();
    public $bankNotFoundCodes = array();

    public function getOldPercent($big, $small)
    {
        return ceil((($big - $small) / $small) * 100);
    }

    public function getNewPrice($price, $mark)
    {
        return $price + round($price * ($mark / 100));
    }

    public function addEmptyCode($code)
    {
        $this->bankNotFoundCodes[] = $code;
    }

    public function getBankNotFoundCodes(): array
    {
        return $this->bankNotFoundCodes;
    }
}