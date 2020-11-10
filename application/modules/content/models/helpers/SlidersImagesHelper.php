<?php

namespace app\modules\content\models\helpers;


use app\modules\content\models\entity\SlidersImages;

class SlidersImagesHelper
{
    public static function getImageUrl(SlidersImages $model, $options = [])
    {
        return '/images/not-image.png';

        if ($model->media) {
            return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);
        }

        return '/upload/' . $model->image;
    }
}