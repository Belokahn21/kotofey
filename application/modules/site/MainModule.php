<?php


namespace app\modules\site;


use app\modules\site\models\entity\ModuleSettings;
use app\modules\site\models\tools\Debug;

class MainModule extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $this->loadParams();
    }

    public function loadParams()
    {
        $module_id = $this->id;

        $values = \Yii::$app->cache->getOrSet('settings:' . $module_id, function () use ($module_id) {
            return ModuleSettings::find()->where(['module_id' => $module_id])->all();
        });

        if (!$values) return false;

        foreach ($values as $param_entity) {
            if (property_exists($this, $param_entity->param_name)) {
                $this->{$param_entity->param_name} = $param_entity->param_value;
            }
        }


        return true;
    }
}