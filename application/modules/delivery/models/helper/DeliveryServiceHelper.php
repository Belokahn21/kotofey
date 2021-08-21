<?php

namespace app\modules\delivery\models\helper;

use app\modules\media\models\entity\Media;
use app\modules\delivery\models\entity\DeliveryService;

class DeliveryServiceHelper
{
    public static function getImageUrl(DeliveryService $model, $options = [])
    {
        if ($model->media) {

            switch ($model->media->location) {
                case Media::LOCATION_SERVER:
                    return '/upload/' . $model->media->name;
                case Media::LOCATION_CDN:
                    return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);
            }
        }

        return false;
    }
}