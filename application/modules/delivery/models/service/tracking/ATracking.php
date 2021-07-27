<?php

namespace app\modules\delivery\models\service\tracking;

use app\modules\delivery\models\service\tracking\api\IDeliveryApi;


/**
 * @var $_api IDeliveryApi
 */
abstract class ATracking implements Tracking
{
    protected $_api;
}