<?php

namespace app\modules\media\models\helpers;


use app\modules\media\models\entity\Media;
use app\modules\site\models\helpers\ImageHelper;
use app\modules\site\models\tools\System;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class MediaHelper
{
    public static function getImageUrl(ActiveRecord $model, $isFull = false, $options = [])
    {
        $url = '';
        $media = ArrayHelper::getValue($model, 'media');

        if ($media instanceof Media) {
            if ($media->location == Media::LOCATION_CDN) {

                if ($options) return \Yii::$app->CDN->resizeImage($media->cdnData['public_id'], $options);

                return $media->cdnData['secure_url'];
            }
            $url = "/upload/" . $media->path;
            $noImage = ImageHelper::notFoundImage();

//            if (empty($media->image)) $url = $noImage;


            if (!is_file(\Yii::getAlias('@webroot/upload/' . $media->path))) $url = $noImage;

            if ($isFull) return System::fullSiteUrl() . $url;

        }

        return $url;
    }
}