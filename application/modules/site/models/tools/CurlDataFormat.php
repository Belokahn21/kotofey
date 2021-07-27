<?php

namespace app\modules\site\models\tools;

use yii\helpers\Json;

class CurlDataFormat
{
    public static function asJson($data)
    {
        return Json::encode($data);
    }

    public static function asFormData($data)
    {
        return http_build_query($data);
    }
}