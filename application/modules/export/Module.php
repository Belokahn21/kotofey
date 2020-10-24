<?php

namespace app\modules\export;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\export\controllers';
    public $exportOrganizationName = 'Зоомагазин Котофей';
    public $exportCompany = 'ИП Васин К.В.';
    public $exportPlatform = 'Зоомагазин Котофей';
    public $exportVersion = '1.0';

    public function init()
    {
        parent::init();
    }
}
