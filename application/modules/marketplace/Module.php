<?php

namespace app\modules\marketplace;

use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $name = 'Маркетплейсы';
    public $controllerNamespace = 'app\modules\marketplace\controllers';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Площадки', 'url' => Url::to(['/admin/marketplace/marketplace-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
