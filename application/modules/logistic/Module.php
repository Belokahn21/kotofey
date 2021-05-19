<?php

namespace app\modules\logistic;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\logistic\controllers';
    private $name = 'Логистика';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Маршруты', 'url' => Url::to(['/admin/logistic/route-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
