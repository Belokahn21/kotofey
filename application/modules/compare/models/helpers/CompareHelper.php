<?php

namespace app\modules\compare\models\helpers;

class CompareHelper
{
    public static function findIdent(array $data)
    {
        $old = '';
        $cnt = 0;
        foreach ($data as $p_id => $value) {

            if ($old == $value) $cnt++;

            $old = $value;
        }


        return count($data) === $cnt + 1;
    }
}