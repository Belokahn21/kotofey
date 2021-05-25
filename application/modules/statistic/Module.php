<?php

namespace app\modules\statistic;

class Module extends \app\modules\site\MainModule
{
    public $name = 'Статистика';
    public $controllerNamespace = 'app\modules\statistic\controllers';

    public function init()
    {
        parent::init();
    }

    public function getName()
    {
        return parent::getName();
    }
}
