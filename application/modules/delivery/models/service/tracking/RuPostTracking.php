<?php


namespace app\modules\delivery\models\service\tracking;

use app\modules\delivery\models\service\tracking\api\RuPostIDeliveryApi;

class RuPostTracking extends ATracking
{
    public function __construct()
    {
        $this->_api = new RuPostIDeliveryApi();
    }

    public function getOrderInfo($track_id)
    {
        return $this->_api->getOrderInfo($track_id);
    }
}