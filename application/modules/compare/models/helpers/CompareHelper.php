<?php

namespace app\modules\compare\models\helpers;

use app\modules\compare\models\entity\Compare;

class CompareHelper
{
    public static function isComparing(int $product_id)
    {
        return in_array($product_id, Compare::getListId());
    }

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