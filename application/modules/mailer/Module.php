<?php

namespace app\modules\mailer;

use app\modules\site\MainModule;
use yii\helpers\Url;

/**
 * mailer module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\mailer\controllers';
    public $name = 'Почта';

    public function init()
    {
        parent::init();
    }


    public function menuIndex()
    {
        return [
            ['name' => 'Почтовые события', 'url' => Url::to(['/admin/mailer/events-backend/index'])],
            ['name' => 'Почтовые шаблоны', 'url' => Url::to(['/admin/mailer/templates-backend/index'])],
        ];
    }

    public function getName()
    {
        return parent::getName();
    }
}
