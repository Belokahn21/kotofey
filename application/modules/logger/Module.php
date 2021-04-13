<?php

namespace app\modules\logger;

use app\modules\site\MainModule;
use yii\helpers\Url;

/**
 * logger module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\logger\controllers';
    private $name = "Логи";

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Логи', 'url' => Url::to(['/admin/logger/log-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
