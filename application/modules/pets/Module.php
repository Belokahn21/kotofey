<?php

namespace app\modules\pets;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\pets\controllers';
    private $name = 'Питомцы';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Карточки питомцев',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
