<?php

namespace app\modules\promocode;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\promocode\controllers';
    public $name = 'Промокоды';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Промокоды', 'url' => Url::to(['/admin/promocode/promocode-backend/index'])],
        ];
    }
}
