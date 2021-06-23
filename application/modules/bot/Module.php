<?php

namespace app\modules\bot;

/**
 * bot module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\bot\controllers';
    private $name = 'Чат-бот';

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
