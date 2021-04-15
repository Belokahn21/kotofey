<?php

namespace app\modules\instagram;

use app\modules\site\MainModule;

/**
 * instagram module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\instagram\controllers';
    private $name = 'Инстаграмм';

    public $instagram_token;

    public function init()
    {
        parent::init();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParams()
    {
        return [
            'instagram_token' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'instagram_token' => 'Токен инстаграмма',
        ];
    }
}
