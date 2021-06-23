<?php

namespace app\modules\compare;

use yii\helpers\Url;

/**
 * compare module definition class
 */
class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\compare\controllers';
    private $name = 'Сравнение товаров';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [];
    }

    public function getName()
    {
        return $this->name;
    }
}
