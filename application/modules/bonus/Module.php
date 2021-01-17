<?php

namespace app\modules\bonus;

use yii\helpers\Url;

/**
 * bonus module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\bonus\controllers';
    private $name = 'Бонусы';
    private $enable = false;

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

    public function getEnable()
    {
        return $this->enable;
    }
}
