<?php

namespace app\modules\news;


use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\news\controllers';
    private $name = 'Новости';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Новости',
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
