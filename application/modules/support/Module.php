<?php

namespace app\modules\support;

use yii\helpers\Url;

/**
 * support module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\support\controllers';
    public $name = 'Тех. поддержка';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Обращения', 'url' => Url::to(['/admin/support/support-backend/index'])],
            ['name' => 'Разделы', 'url' => Url::to(['/admin/support/support-category-backend/index'])],
            ['name' => 'Статусы', 'url' => Url::to(['/admin/support/support-status-backend/index'])],
        ];
    }
}
