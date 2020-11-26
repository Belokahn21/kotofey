<?php

namespace app\modules\geo;

use yii\helpers\Url;

/**
 * geo module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\geo\controllers';
    private $name = 'Гео-данные';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }



    public function menuIndex()
    {
        return [
            [
                'name' => 'Города',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
