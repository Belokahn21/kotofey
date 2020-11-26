<?php

namespace app\modules\content;

use yii\helpers\Url;

/**
 * content module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\content\controllers';
    public $name = 'Контент';

    public function init()
    {
        parent::init();
    }


    public function menuIndex()
    {
        return [
            [
                'name' => 'Слайдеры',
                'url' => Url::to(),
            ],
            [
                'name' => 'Изображения',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }

}
