<?php


namespace app\modules\order\models\service;


use app\modules\delivery\models\service\tracking\CdekTracking;
use app\modules\delivery\models\service\tracking\DpdTracking;
use app\modules\delivery\models\service\tracking\RuPostTracking;
use app\modules\delivery\models\service\tracking\Tracking;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderTracking;

/**
 * @var $_order Order
 * @var $_track_model OrderTracking
 * @var $_service Tracking
 */
class TrackingService
{
    private $_order;
    private $_service;
    private $_track_model;

    public function __construct(Order $order)
    {
        $this->_order = $order;

        $this->getTrackModel();
    }

    public function getTrackModel()
    {
        $this->_track_model = OrderTracking::findByOrderId($this->_order->id);
    }

    public function choseService()
    {
        switch ($this->_track_model->service_id) {
            case OrderTracking::SERVICE_RUSSIAN_POST:
                $this->_service = new RuPostTracking();
                break;
            case OrderTracking::SERVICE_DPD:
                $this->_service = new DpdTracking();
                break;
            case OrderTracking::SERVICE_CDEK:
                $this->_service = new CdekTracking();
                break;
            default:
                throw new \Exception('Сервис доставки не указан.');
        }
    }

    public function getDateDelivery()
    {
    }

    public function getStatusDelivery()
    {
        $this->_service->getStatusDelivery();
    }
}