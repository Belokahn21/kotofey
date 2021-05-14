<?php


namespace app\modules\delivery\models\service\tracking\api;


use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuthApiInterface;

/**
 * @property CdekAuthApiInterface $auth
 */
interface TrackingApi
{
    public function getOrderInfo(string $track_id);
}