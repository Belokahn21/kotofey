<?php


namespace app\modules\delivery\models\service\tracking;


use app\modules\delivery\models\service\tracking\api\TrackingApi;

abstract class ATracking implements Tracking
{
    protected $_api;
}