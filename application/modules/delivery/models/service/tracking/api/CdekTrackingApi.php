<?php

namespace app\modules\delivery\models\service\tracking\api;

use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuth;

class CdekTrackingApi implements TrackingApi
{
    public function __construct()
    {
        $this->auth = new CdekAuth();
    }

    public function getOrderInfo(string $track_id)
    {
        $this->request();
    }

    public function request($url, $data)
    {

    }
}