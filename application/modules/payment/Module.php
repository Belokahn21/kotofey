<?php

namespace app\modules\payment;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\payment\controllers';
    public $name = 'Оплаты';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Оплаты', 'url' => Url::to(['/admin/payment/payment-backend/index'])],
        ];
    }
}
