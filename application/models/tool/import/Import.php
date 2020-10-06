<?php


namespace app\models\tool\import;


interface Import
{
    public function getPricePath();
    public function getOldPercent($big, $small);
}