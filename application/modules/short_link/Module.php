<?php

namespace app\modules\short_link;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\short_link\controllers';
    public $name = 'Короткие ссылки';

    public function init()
    {
        parent::init();

    }

    public function menuIndex()
    {
        return [
            ['name' => 'Короткие ссылки', 'url' => Url::to(['/admin/short_link/short-link-backend/index'])],
        ];
    }
}
