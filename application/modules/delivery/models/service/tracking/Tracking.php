<?php


namespace app\modules\delivery\models\service\tracking;


interface Tracking
{
    public function getOrderInfo($track_id);
}