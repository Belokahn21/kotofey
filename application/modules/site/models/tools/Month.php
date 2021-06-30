<?php

namespace app\modules\site\models\tools;

use yii\helpers\ArrayHelper;

class Month
{
    public static function getLabelCurrentMonth($month_id)
    {
        $list = ['Январь', 'Февраль', 'Март', 'Аперль', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        return ArrayHelper::getValue($list, $month_id);
    }
}