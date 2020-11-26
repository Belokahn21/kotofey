<?php

namespace app\modules\user;

use yii\helpers\Url;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';
    public $avatarPath = "/upload/avatar/";
    private $name = "Пользователи";

    public function init()
    {
        parent::init();
    }


    public function menuIndex()
    {
        return [
            [
                'name' => 'Пользователи',
                'url' => Url::to(),
            ],
            [
                'name' => 'Разрешения',
                'url' => Url::to(),
            ],
            [
                'name' => 'Группы',
                'url' => Url::to(),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
