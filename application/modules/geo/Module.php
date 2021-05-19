<?php

namespace app\modules\geo;

use yii\helpers\Url;

/**
 * geo module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\geo\controllers';
    private $name = 'Гео-данные';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Города', 'url' => Url::to(['/admin/geo/geo-backend/index'])],
            ['name' => 'Временные зоны', 'url' => Url::to(['/admin/geo/timezone-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
