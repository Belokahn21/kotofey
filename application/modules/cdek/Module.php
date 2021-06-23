<?php

namespace app\modules\cdek;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\cdek\controllers';
    private $name = 'Сдек';

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
