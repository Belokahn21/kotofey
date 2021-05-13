<?php


namespace app\modules\delivery\models\service\tracking\api;


interface TrackingApi
{
    public function getOrderInfo(string $track_id);
}