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
    public $dkim_private_key;
    public $dkim_domain;
    public $dkim_selector;

    public function init()
    {
        parent::init();
    }

    public function getParams()
    {
        $events = MailEvents::find()->all();
        return [
            'remember_event_id' => ArrayHelper::map($events, 'id', 'name'),
            'dkim_private_key' => '',
            'dkim_domain' => '',
            'dkim_selector' => '',
        ];
    }

    public function getParamsLabel()
    {
        return [
            'remember_event_id' => 'Почтовое событие для рассылки потеряшек',
            'dkim_private_key' => 'dkim_private_key',
            'dkim_domain' => 'dkim_domain',
            'dkim_selector' => 'dkim_selector',
        ];
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Почтовые события', 'url' => Url::to(['/admin/mailer/events-backend/index'])],
            ['name' => 'Почтовые шаблоны', 'url' => Url::to(['/admin/mailer/templates-backend/index'])],
            ['name' => 'История', 'url' => Url::to(['/admin/mailer/history-backend/index'])],
        ];
    }

    public function getName()
    {
        return parent::getName();
    }
}
