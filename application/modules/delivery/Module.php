<?php

namespace app\modules\delivery;

use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\delivery\controllers';
    private $name = 'Доставка';

    public $default_index_from;

    public $cdek_client_id_dev;
    public $cdek_client_secret_dev;
    public $cdek_client_id_prod;
    public $cdek_client_secret_prod;
    public $cdek_default_tariff_code;

    public $ru_post_login;
    public $ru_post_password;
    public $ru_post_default_tariff_code;

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Доставки', 'url' => Url::to(['/admin/delivery/delivery-backend/index'])],
            ['name' => 'Транспортные компании', 'url' => Url::to(['/admin/delivery/services-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }


    public function getParams()
    {
        return [
            'default_index_from' => '',

            'cdek_client_id_dev' => '',
            'cdek_client_secret_dev' => '',
            'cdek_client_id_prod' => '',
            'cdek_client_secret_prod' => '',
            'cdek_default_tariff_code' => '',

            'ru_post_login' => '',
            'ru_post_password' => '',
            'ru_post_default_tariff_code' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'default_index_from' => 'Индекс города отправителя(По умолчанию)',

            'cdek_client_id_dev' => 'ID клиента(dev)',
            'cdek_client_secret_dev' => 'Секретный ключ(dev)',
            'cdek_client_id_prod' => 'ID клиента(prod)',
            'cdek_client_secret_prod' => 'Секретный ключ(prod)',
            'cdek_default_tariff_code' => '(Cdek) Тариф отправок по умолчанию',

            'ru_post_login' => 'Почта России, логин',
            'ru_post_password' => 'Почта России, пароль',
            'ru_post_default_tariff_code' => '(Почта России) Тариф отправок по умолчанию',
        ];
    }
}
