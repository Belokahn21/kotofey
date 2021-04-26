<?php

namespace app\modules\subscribe;

use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\subscribe\controllers';
    private $name = 'Подписки';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Подписки', 'url' => Url::to(['/admin/subscribe/subscribe-backend/index']),],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
