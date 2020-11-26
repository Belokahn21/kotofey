<?php

namespace app\modules\catalog;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\catalog\controllers';
    private $name = 'Каталог';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Товары',
                'url' => Url::to(),
            ],
            [
                'name' => 'Разделы',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
