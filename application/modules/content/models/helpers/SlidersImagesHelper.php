<?php

namespace app\modules\content\models\helpers;


use app\modules\content\models\entity\SlidersImages;
use app\modules\media\models\entity\Media;
use app\modules\site\models\tools\Debug;

class SlidersImagesHelper
{
    public static function getImageUrl(SlidersImages $model, $options = [])
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $model->id, function () use ($model, $options) {
            if ($media = $model->media) {

                switch ($media->location) {
                    case Media::LOCATION_SERVER:
                        return '/upload/' . $media->name;
                    case Media::LOCATION_CDN:
                        return \Yii::$app->CDN->resizeImage($media->cdnData['public_id'], $options);
                }
            }

            return false;
        });
    }
}