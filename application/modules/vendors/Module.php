<?php

namespace app\modules\vendors;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\vendors\controllers';
    private $name = 'Поставщики';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Поставщики', 'url' => Url::to(['/admin/vendors/vendors-backend/index'])],
            ['name' => 'Группы поставщиков', 'url' => Url::to(['/admin/vendors/vendors-group-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
