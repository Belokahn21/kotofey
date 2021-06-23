<?php

namespace app\modules\todo;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\todo\controllers';
    private $name = 'Список задач';

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
