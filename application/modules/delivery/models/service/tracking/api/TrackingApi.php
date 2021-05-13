<?php


namespace app\modules\delivery\models\service\tracking\api;


interface TrackingApi
{
    public function getStatusDelivery(string $track_id);
}