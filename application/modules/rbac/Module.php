<?php

namespace app\modules\rbac;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\rbac\controllers';
    private $name = 'RBAC-Контроль доступа';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [];
    }

    public function getName()
    {
        return $this->name;
    }
}
