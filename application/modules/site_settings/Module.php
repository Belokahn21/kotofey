<?php

namespace app\modules\site_settings;

use yii\helpers\Url;

/**
 * site_settings module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\site_settings\controllers';
    private $name = 'Настройки';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Список настроек', 'url' => Url::to(['/admin/site_settings/settings-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
