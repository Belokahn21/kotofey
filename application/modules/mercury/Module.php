<?php

namespace app\modules\mercury;

use app\modules\site\MainModule;
use yii\helpers\Url;

/**
 * Модуль работы с Меркурий ВетИС
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\mercury\controllers';
    private $name = 'Меркурий ВетИС';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Документы', 'url' => Url::to(['/admin/mercury/vsd-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
