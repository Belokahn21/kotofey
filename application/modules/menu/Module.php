<?php

namespace app\modules\menu;

use app\modules\site\MainModule;
use yii\helpers\Url;

/**
 * menu module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\menu\controllers';
    public $name = "Меню";

    public function init()
    {
        parent::init();
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
