<?php

namespace app\modules\site\models\helpers;


class PhoneHelper
{
    public static function formatPhone($phone)
    {
        return '+7' . substr($phone, '1', strlen($phone));
    }
}