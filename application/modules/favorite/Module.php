<?php

namespace app\modules\favorite;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\favorite\controllers';
    private $name = 'Избранные товары';

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
