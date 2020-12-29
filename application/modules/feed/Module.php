<?php

namespace app\modules\feed;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\feed\controllers';
    public $name = 'Промокоды';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Поисковой контент', 'url' => Url::to(['/admin/feed/feed/index'])],
        ];
    }
}
