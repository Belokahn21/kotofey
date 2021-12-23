<?php

namespace app\modules\delivery\widgets\ProfileTracking;

use app\modules\logger\models\service\LogService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderTracking;
use app\modules\order\models\service\TrackingApiService;
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
            $trackingApiService = new TrackingApiService($this->order);
            if ($trackingApiService) {
                $tracking_info = $trackingApiService->getOrderInfo();
            }
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