<?php

namespace app\modules\content\models\helpers;


use app\modules\content\models\entity\SlidersImages;
use app\modules\media\models\entity\Media;
use app\modules\site\models\tools\Debug;

class SlidersImagesHelper
{
    public static function getImageUrl(SlidersImages $model, $options = [])
    {
        if (Debug::isPageSpeed()) {
            return '/images/not-image.png';
        }

        if ($model->media) {

            switch ($model->media->location) {
                case Media::LOCATION_SERVER:
                    return '/upload/' . $model->media->name;
                    break;
                case Media::LOCATION_CDN:
                    return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);
                    break;
            }
        }

        return false;
    }
}