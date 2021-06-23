<?php

namespace app\modules\search;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\search\controllers';
    private $name = 'Поиск';

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
