<?php

namespace app\modules\cdn;

use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\cdn\controllers';
    public $name = 'CDN';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Ресурсы', 'url' => Url::to(['/admin/cdn/cdn-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
