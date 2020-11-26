<?php

namespace app\modules\vendors;

use yii\helpers\Url;

/**
 * vendor module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\vendors\controllers';
    private $name = 'Поставщики';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Поставщики',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
