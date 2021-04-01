<?php


namespace app\modules\site\models\helpers;


class ModuleSettingsHelper
{
    public static function getLabel($attr, $module)
    {
        return $module->getParamsLabel()[$attr];
    }
}