<?php

namespace app\modules\acquiring;

use app\modules\site\MainModule;
use yii\helpers\Url;

/**
 * acquiring module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\acquiring\controllers';
    private $name = 'Эквайринг';

    public $is_enable;
    public $test_login;
    public $test_password;
    public $test_token;
    public $real_login;
    public $real_password;
    public $real_token;
    public $bank;
    public $mode;
    public $ofd_token;
    public $inn;


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
            'is_enable' => true,
            'test_login' => '',
            'test_password' => '',
            'test_token' => '',
            'real_login' => '',
            'real_password' => '',
            'real_token' => '',
            'bank' => [
                'sberbank' => 'Сбербанк',
                'alfabank' => 'Альфа-Банк'
            ],
            'mode' => [
                'on' => 'Боевой режим',
                'off' => 'Отключен',
                'test' => 'Тестовый режим'
            ],
            'ofd_token' => '',
            'inn' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'isEnable' => 'Включен/выключен',

            'test_login' => 'Логин (Test)',
            'test_password' => 'Пароль (Test)',
            'test_token' => 'Токен (Test)',

            'real_login' => 'Логин (Боевой)',
            'real_password' => 'Пароль (Боевой)',
            'real_token' => 'Токен (Боевой)',

            'ofd_token' => 'Токен авторизации OFD.RU',
            'inn' => 'ИНН организации'
        ];
    }
}
