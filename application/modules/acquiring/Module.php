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
    public $inn;
    public $ofd_mode;
    public $ofd_login;
    public $ofd_password;
    public $ofd_taxation_system;

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Оплаты', 'url' => Url::to(['/admin/acquiring/acquiring-backend/index'])],
            ['name' => 'Чеки', 'url' => Url::to(['/admin/acquiring/acquiring-check-backend/index'])],
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
            'inn' => '',
            'ofd_mode' => [
                'on' => 'Работает',
                'off' => 'Не работает',
            ],
            'ofd_login' => '',
            'ofd_password' => '',
            'ofd_taxation_system' => [
                'Common' => 'общая система налогообложения',
                'SimpleIn' => 'упрощенная система налогообложения (доход)',
                'SimpleInOut' => 'упрощенная система налогообложения (доход минус расход)',
                'Unified' => 'единый налог на вмененный доход',
                'UnifiedAgricultural' => 'единый сельскохозяйственный налог',
                'Patent' => 'патентная система налогообложения',
            ],
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

            'bank' => 'Банк эквайринга',
            'mode' => 'Режим эквайринга',

            'inn' => 'ИНН организации',
            'ofd_mode' => 'Отправка чеков',
            'ofd_login' => 'Логин lk.ofd.ru',
            'ofd_password' => 'Пароль lk.ofd.ru',
            'ofd_taxation_system' => 'Система налогаобложения',
        ];
    }
}
