<?php

namespace app\modules\vacancy;

use yii\helpers\Url;

/**
 * vacancy module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\vacancy\controllers';
    private $name = "Вакансии";

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Вакансии', 'url' => Url::to(['/admin/vacancy/vacancy-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
