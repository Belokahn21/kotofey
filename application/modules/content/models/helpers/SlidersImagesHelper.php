<?php

namespace app\modules\content\models\helpers;


use app\modules\content\models\entity\SlidersImages;
use app\modules\media\models\entity\Media;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\System;

class SlidersImagesHelper
{
    public static function getImageUrl(SlidersImages $model, $isFull = false, $options = [])
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $model->id . $isFull, function () use ($model, $isFull, $options) {
            if ($media = $model->media) {

                switch ($media->location) {
                    case Media::LOCATION_SERVER:
                        $path = '/upload/' . $media->name;
                        if ($isFull) $path = System::fullSiteUrl() . $path;
                        return $path;
                    case Media::LOCATION_CDN:
                        return \Yii::$app->CDN->resizeImage($media->cdnData['public_id'], $options);
                }
            }

            return false;
        });
    }
}