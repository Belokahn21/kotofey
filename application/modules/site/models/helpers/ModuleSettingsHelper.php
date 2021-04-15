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


    public static function updateByParam($param_name, $param_value)
    {
        $param = ModuleSettings::findOne(['module_id' => 'instagram', 'param_name' => $param_name]);

        if (!$param) throw new \Exception('Параметр не существует');

        $param->param_value = $param_value;

        return $param->validate() && $param->update();
    }
}