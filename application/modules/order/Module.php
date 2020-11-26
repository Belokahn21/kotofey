<?php

namespace app\modules\order;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\order\controllers';
    private $name = 'Заказы';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Заказы',
                'url' => Url::to(),
            ],
            [
                'name' => 'Статусы',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
