<?php


namespace app\modules\delivery\models\service\tracking;

use app\modules\delivery\models\service\tracking\api\RuPostTrackingApi;

class RuPostTracking extends ATracking
{
    public function __construct()
    {
        $this->_api = new RuPostTrackingApi();
    }

    public function getStatusDelivery()
    {
    }
}