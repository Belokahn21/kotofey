<?php

namespace app\modules\delivery;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\delivery\controllers';
    private $name = 'Доставка';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Доставки', 'url' => Url::to(['/admin/delivery/delivery-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
