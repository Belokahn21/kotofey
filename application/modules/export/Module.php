<?php

namespace app\modules\export;

/**
 * @property string $exportOrganizationName;
 * @property string $exportCompany;
 * @property string $exportPlatform;
 * @property string $exportVersion;
 */
class Module extends \app\modules\site\MainModule
{
    public $name = 'YML Экспорт';
    public $controllerNamespace = 'app\modules\export\controllers';
    public $exportOrganizationName;
    public $exportCompany;
    public $exportPlatform;
    public $exportVersion;

    public function init()
    {
        parent::init();
    }

    public function getParams()
    {
        return [
            'exportOrganizationName' => '',
            'exportCompany' => '',
            'exportPlatform' => '',
            'exportVersion' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'exportOrganizationName' => '(export) Название организации',
            'exportCompany' => '(export) Юридическое название',
            'exportPlatform' => '(export) Имя платформы',
            'exportVersion' => '(export) Версия',
        ];
    }
}
