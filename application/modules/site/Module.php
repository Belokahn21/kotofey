<?php

namespace app\modules\site;

use yii\helpers\Url;

/**
 * site module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\site\controllers';
    private $name = 'Сайт';

    public function getName(): string
    {
        return $this->name;
    }
}
