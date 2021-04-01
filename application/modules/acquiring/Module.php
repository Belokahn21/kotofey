<?php

namespace app\modules\acquiring;

use yii\helpers\Url;

/**
 * acquiring module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\acquiring\controllers';
    private $name = 'Эквайринг';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Оплаты', 'url' => Url::to(['/admin/acquiring/acquiring-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParams()
    {
        return [
            'isEnable' => true,
            'login' => '',
            'password' => '',
            'token' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'isEnable' => 'Включен/выключен',
            'login' => 'Логин',
            'password' => 'Пароль',
            'token' => 'Токен',
        ];
    }
}
