<?php

namespace app\modules\order;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\site\MainModule;
use app\modules\user\models\helpers\UserHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\order\controllers';
    private $name = 'Заказы';

    public $default_manager_id;
    public $mail_event_id_order_ready;

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Заказы', 'url' => Url::to(['/admin/order/order-backend/index'])],
            ['name' => 'Статусы заказа', 'url' => Url::to(['/admin/order/order-status-backend/index'])],
            ['name' => 'Кабинет оператора', 'url' => Url::to(['/admin/order/operator-backend/index'])],
            ['name' => 'Карточки покупателей', 'url' => Url::to(['/admin/order/customer-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }


    public function getParams()
    {
        return [
            'default_manager_id' => ArrayHelper::map(UserHelper::getManagers(), 'id', 'email'),
            'mail_event_id_order_ready' => ArrayHelper::map(MailEvents::find()->all(), 'id', 'name'),
        ];
    }

    public function getParamsLabel()
    {
        return [
            'default_manager_id' => 'Менеджер заказов по умолчанию',
            'mail_event_id_order_ready' => 'ID почтового события, заказ готов к выдаче',
        ];
    }
}
