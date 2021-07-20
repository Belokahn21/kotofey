<?php

namespace app\modules\mailer;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\site\MainModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * mailer module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\mailer\controllers';
    public $name = 'Почта';

    public $remember_event_id;

    public function init()
    {
        parent::init();
    }

    public function getParams()
    {
        return [
            'remember_event_id' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'remember_event_id' => 'Почтовое событие для рассылки потеряшек',
        ];
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
