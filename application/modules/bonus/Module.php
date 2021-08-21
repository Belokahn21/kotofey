<?php

namespace app\modules\bonus;

use yii\helpers\Url;

/**
 * bonus module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\bonus\controllers';
    private $name = 'Бонусы';
    private $enable = true;

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Аккаунты', 'url' => Url::to(['/admin/bonus/bonus-backend/index'])],
            ['name' => 'История начислений', 'url' => Url::to(['/admin/bonus/bonus-history-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
