<?php

namespace app\modules\menu_fast;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\menu_fast\controllers';
    private $name = 'Быстрое меню';

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
