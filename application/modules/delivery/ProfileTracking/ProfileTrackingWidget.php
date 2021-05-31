<?php

namespace app\modules\delivery\ProfileTracking;

use app\modules\logger\models\entity\Logger;
use app\modules\logger\models\service\LogService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderTracking;
use app\modules\order\models\service\TrackingService;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;

/**
 * @property Order $order
 */
class ProfileTrackingWidget extends Widget
{
    public $order;
    public $view = 'default';

    public function run()
    {
        $tracking_info = null;
        $track_model = OrderTracking::findByOrderId($this->order->id);
        try {
            $trackServivce = new TrackingService($this->order);
            $trackServivce->track_model = $track_model;
            $tracking_info = $trackServivce->getOrderInfo();
        } catch (\Exception $x) {
            LogService::saveWarningMessage($x->getMessage(), 'profile-order-tracking');
        }

        if ($tracking_info === null) return false;


        if ($track_model->service_id == OrderTracking::SERVICE_CDEK) {
            $this->view = 'default';
        }

        if ($track_model->service_id == OrderTracking::SERVICE_RUSSIAN_POST) {
            $this->view = 'ru_post';
        }

        return $this->render($this->view, [
            'tracking_info' => $tracking_info
        ]);
    }
}