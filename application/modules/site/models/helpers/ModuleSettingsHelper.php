<?php


namespace app\modules\site\models\helpers;


use app\modules\site\models\entity\ModuleSettings;

class ModuleSettingsHelper
{
    public static function getValue($moduleId, $param)
    {
        $model = ModuleSettings::findOne(['module_id' => $moduleId, 'param_name' => $param]);

        if ($model) return $model->param_value;

        return false;
    }
}