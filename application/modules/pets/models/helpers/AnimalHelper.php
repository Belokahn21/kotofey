<?php

namespace app\modules\pets\models\helpers;

use app\modules\media\models\entity\Media;
use app\modules\pets\models\entity\Animal;
use app\modules\site\models\tools\System;

class AnimalHelper
{
    public static function getImageUrl(Animal $model, $isFull = false, $options = [])
    {

        if ($media = $model->media) {
            if ($media->location == Media::LOCATION_CDN) {

                if ($options) return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);

                return $media->cdnData['secure_url'];
            }
            $url = "/upload/" . $media->name;
            $noImage = "/upload/images/not-image.png";

            if (empty($model->image)) $url = $noImage;


            if (!is_file(\Yii::getAlias('@webroot/upload/' . $media->name))) $url = $noImage;

            if ($isFull) return System::fullSiteUrl() . $url;

            return $url;
        }

        // for old engine
        $url = "/upload/" . $model->image;
        $noImage = "/upload/images/not-image.png";

        if (empty($model->image)) {
            $url = $noImage;
        }

        if (!is_file(\Yii::getAlias('@webroot/upload/' . $model->image))) $url = $noImage;


        if ($isFull) return System::fullSiteUrl() . $url;

        return $url;
    }
}