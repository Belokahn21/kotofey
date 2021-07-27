<?php


namespace app\modules\delivery\models\service\tracking;


use app\modules\delivery\models\service\tracking\api\CdekApi;
use app\modules\delivery\models\service\tracking\api\IDeliveryApi;

/**
 * @var $_api IDeliveryApi
 */
class CdekTracking extends ATracking
{
    public function __construct()
    {
        $this->_api = new CdekApi();
    }

    public function getOrderInfo($track_id)
    {
        return $this->_api->getOrderInfo($track_id);
    }
}