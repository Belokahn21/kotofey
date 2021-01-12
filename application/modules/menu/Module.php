<?php

namespace app\modules\menu;

use yii\helpers\Url;

/**
 * menu module definition class
 */
class Module extends \yii\base\Module
{
    public $name = "Меню";
    public $controllerNamespace = 'app\modules\menu\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Списки меню', 'url' => Url::to(['/admin/menu/menu-backend/index'])],
            ['name' => 'Пункты меню', 'url' => Url::to(['/admin/menu/menu-items-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
