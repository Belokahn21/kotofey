<?php

namespace app\modules\order;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\order\models\entity\OrderStatus;
use app\modules\site\MainModule;
use app\modules\user\models\helpers\UserHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\order\controllers';
    private $name = 'Магазин';

    public $default_manager_id;
    public $mail_event_id_order_ready;
    public $mail_event_id_order_created;
    public $mail_event_id_order_complete;
    public $order_default_status_id;

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
            ['name' => 'Статусы покупателей', 'url' => Url::to(['/admin/order/customer-status-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }


    public function getParams()
    {
        $events = MailEvents::find()->all();
        $status = OrderStatus::find()->all();
        return [
            'default_manager_id' => ArrayHelper::map(UserHelper::getManagers(), 'id', 'email'),
            'mail_event_id_order_ready' => ArrayHelper::map($events, 'id', 'name'),
            'mail_event_id_order_created' => ArrayHelper::map($events, 'id', 'name'),
            'mail_event_id_order_complete' => ArrayHelper::map($events, 'id', 'name'),
            'order_default_status_id' => ArrayHelper::map($status, 'id', 'name'),
        ];
    }

    public function getParamsLabel()
    {
        return [
            'default_manager_id' => 'Менеджер заказов по умолчанию',
            'mail_event_id_order_ready' => 'ID почтового события, заказ готов к выдаче',
            'mail_event_id_order_created' => 'ID почтового события, заказ создан',
            'mail_event_id_order_complete' => 'ID почтового события, заказ завершен',
            'order_default_status_id' => 'Статус заказа по умолчанию',
        ];
    }
}
