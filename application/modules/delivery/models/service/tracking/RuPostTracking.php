<?php


namespace app\modules\delivery\models\service\tracking;

use app\modules\delivery\models\service\tracking\api\RuPostTrackingApi;

class RuPostTracking extends ATracking
{
    public function __construct()
    {
        $this->_api = new RuPostTrackingApi();
    }

    public function getOrderInfo($track_id)
    {
        return $this->_api->getOrderInfo($track_id);
    }
}