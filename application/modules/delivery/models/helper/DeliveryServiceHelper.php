<?php

namespace app\modules\delivery\models\helper;

use app\modules\media\models\entity\Media;
use app\modules\delivery\models\entity\DeliveryService;
use app\modules\media\models\helpers\MediaHelper;

class DeliveryServiceHelper
{
    public static function getImageUrl(DeliveryService $model, $isFull = false, $options = [])
    {
        return MediaHelper::getImageUrl($model, $isFull, $options);
    }
}