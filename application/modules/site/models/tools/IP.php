<?php

namespace app\modules\site\models\tools;

use yii\helpers\Json;

class IP
{
    public static function getIpInfo($ip)
    {
        return \Yii::$app->cache->getOrSet($ip, function () use ($ip) {
            $ip_data = Json::decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip), true);
            if ($ip_data && $ip_data['geoplugin_countryName'] != null) {
                return $ip_data;
            }

            return false;
        });
    }
}