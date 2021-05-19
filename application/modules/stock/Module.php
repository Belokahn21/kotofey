<?php

namespace app\modules\stock;

use yii\helpers\Url;

/**
 * stock module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\stock\controllers';
    private $name = 'Склады';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Склады', 'url' => Url::to(['/admin/stock/stock-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
