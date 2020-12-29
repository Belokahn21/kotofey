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
            ['name' => 'Пользователи', 'url' => Url::to(['/admin/user/user-backend/index'])],
            ['name' => 'Группы', 'url' => Url::to(['/admin/user/user-group-backend/index'])],
            ['name' => 'Разрешения', 'url' => Url::to(['/admin/user/user-permission-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
