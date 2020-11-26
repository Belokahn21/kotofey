<?php

namespace app\modules\delivery;

use yii\helpers\Url;

/**
 * delivery module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\delivery\controllers';
    private $name = 'Доставка';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Доставки',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
