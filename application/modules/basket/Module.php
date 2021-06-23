<?php

namespace app\modules\basket;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\basket\controllers';
    private $name = 'Корзина';

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
