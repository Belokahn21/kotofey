<?php

namespace app\modules\delivery\ProfileTracking;

use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrderTracking;
use app\modules\order\models\service\TrackingService;
use yii\base\Widget;

/**
 * @property Order $order
 */
class ProfileTrackingWidget extends Widget
{
    public $view = 'default';
    public $order;

    public function run()
    {
        try {
            $trackServivce = new TrackingService($this->order);
            $tracking_info = $trackServivce->getOrderInfo();
        } catch (\Exception $x) {
            echo $x->getMessage();
        }

        return $this->render($this->view, [
            'tracking_info' => $tracking_info
        ]);
    }
}