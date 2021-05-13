<?php


namespace app\modules\delivery\models\service\tracking;


use app\modules\delivery\models\service\tracking\api\CdekTrackingApi;
use app\modules\delivery\models\service\tracking\api\TrackingApi;

/**
 * @var $_api TrackingApi
 */
class CdekTracking extends ATracking
{
    public function __construct()
    {
        $this->_api = new CdekTrackingApi();
    }

    public function getOrderInfo($track_id)
    {
        $this->_api->getOrderInfo($track_id);
    }
}