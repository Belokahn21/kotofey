<?php

namespace app\modules\marketplace;

use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\marketplace\controllers';
    public $name = 'Маркетплейсы';

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
        return parent::getName();
    }
}
